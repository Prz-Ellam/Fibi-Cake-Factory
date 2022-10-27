<?php

namespace Fibi\Http;

use Fibi\Helpers\UploadedFile;
use Fibi\Http\Request;

abstract class RequestBuilder
{
    public static function createFromPhpServer() : Request
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST" && $_SERVER["REQUEST_METHOD"] !== "GET") {
            self::decode();
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") self::cleanFiles();

        return (new Request())
            ->setUri(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH))
            ->setMethod(HttpMethod::from($_SERVER["REQUEST_METHOD"]))
            ->setBody(($_SERVER["REQUEST_METHOD"] === "POST") ? $_POST : $_REQUEST)
            ->setQuery($_GET)
            ->setHeaders(getallheaders())
            ->setFiles(self::createUploadedFiles($_FILES));
    }

    private static function parsePut(  ) : array {
        global $_PUT;

        /* PUT data comes in on the stdin stream */
        $putdata = fopen("php://input", "r");

        /* Open a file for writing */
        // $fp = fopen("myputfile.ext", "w");

        $raw_data = '';

        /* Read the data 1 KB at a time
        and write to the file */
        while ($chunk = fread($putdata, 1024))
            $raw_data .= $chunk;

        /* Close the streams */
        fclose($putdata);

        // Fetch content and determine boundary
        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        if(empty($boundary)){
            parse_str($raw_data,$data);
            $GLOBALS[ '_PUT' ] = $data;
            return $data;
        }

        // Fetch each part
        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data = array();

        foreach ($parts as $part) {
            // If this is the last part, break
            if ($part == "--\r\n") break;

            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

            // Parse the headers list
            $raw_headers = explode("\r\n", $raw_headers);
            $headers = array();
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                $tmp_name = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                list(, $type, $name) = $matches;

                //Parse File
                if( isset($matches[4]) )
                {
                    //if labeled the same as previous, skip
                    if( isset( $_FILES[ $matches[ 2 ] ] ) )
                    {
                        continue;
                    }

                    //get filename
                    $filename = $matches[4];

                    //get tmp name
                    $filename_parts = pathinfo( $filename );
                    $tmp_name = tempnam( ini_get('upload_tmp_dir'), $filename_parts['filename']);

                    //populate $_FILES with information, size may be off in multibyte situation
                    $_FILES[ $matches[ 2 ] ] = array(
                        'error'=>0,
                        'name'=>$filename,
                        'tmp_name'=>$tmp_name,
                        'size'=>strlen( $body ),
                        'type'=>$value
                    );

                    //place in temporary directory
                    file_put_contents($tmp_name, $body);
                }
                //Parse Field
                else
                {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }

        }
        $GLOBALS[ '_PUT' ] = $data;
        return $data;
    }

    public static function decode()
    {
        $files = [];
        $data  = [];
        // Fetch content and determine boundary
        $rawData  = file_get_contents('php://input');
        $boundary = substr($rawData, 0, strpos($rawData, "\r\n"));
        // Fetch and process each part
        $parts = $rawData ? array_slice(explode($boundary, $rawData), 1) : [];
        foreach ($parts as $part) {
            // If this is the last part, break
            if ($part == "--\r\n") {
                break;
            }
            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($rawHeaders, $content) = explode("\r\n\r\n", $part, 2);
            $content = substr($content, 0, strlen($content) - 2);
            // Parse the headers list
            $rawHeaders = explode("\r\n", $rawHeaders);
            $headers    = array();
            foreach ($rawHeaders as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }
            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^form-data; *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                $fieldName = $matches[1];
                $fileName  = (isset($matches[3]) ? $matches[3] : null);
                // If we have a file, save it. Otherwise, save the data.
                if ($fileName !== null) {
                    $localFileName = tempnam(sys_get_temp_dir(), 'sfy');
                    file_put_contents($localFileName, $content);
                    $files = self::transformData($files, $fieldName, [
                        'name'     => $fileName,
                        'type'     => $headers['content-type'],
                        'tmp_name' => $localFileName,
                        'error'    => 0,
                        'size'     => filesize($localFileName)
                    ]);
                    // register a shutdown function to cleanup the temporary file
                    register_shutdown_function(function () use ($localFileName) {
                        unlink($localFileName);
                    });
                } else {
                    $data = self::transformData($data, $fieldName, $content);
                }
            }
        }

        $_REQUEST = $data;
        $_FILES = $files;
    }

    private static function transformData($data, $name, $value)
    {
        $isArray = strpos($name, '[]');
        if ($isArray && (($isArray + 2) == strlen($name))) {
            $name = str_replace('[]', '', $name);
            $data[$name][]= $value;
        } else {
            $data[$name] = $value;
        }
        return $data;
    }

    public static function cleanFiles()
    {
        $out = [];
        foreach ($_FILES as $key => $file) {
            if (isset($file['name']) && is_array($file['name'])) {
                $new = [];
                foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $k) {
                    array_walk_recursive($file[$k], function (&$data, $key, $k) {
                        $data = [$k => $data];
                    }, $k);
                    $new = array_replace_recursive($new, $file[$k]);
                }
                $out[$key] = $new;
            } else {
                $out[$key] = $file;
            }
        }
        $_FILES = $out;
    }

    public static function createUploadedFiles($files): array
    {
        $outputFiles = [];

        foreach ($files as $key => $file)
        {
            if (count($file) !== count($file, COUNT_RECURSIVE))
            {
                // Multidimensional
                foreach ($file as $element)
                {
                    $outputFiles[$key][] = new UploadedFile(
                        $element["name"] ?? null,
                        $element["path"] ?? null,
                        $element["tmp_name"] ?? null,
                        $element["size"] ?? null,
                        $element["type"] ?? null
                    );
                }
            }
            else
            {
                // Not multidimensional
                $outputFiles[$key] = new UploadedFile(
                    $file["name"] ?? null,
                    $file["path"] ?? null,
                    $file["tmp_name"] ?? null,
                    $file["size"] ?? null,
                    $file["type"] ?? null
                );
            }

        }

        return $outputFiles;
    }

    public static function createFromMockup() : Request|null
    {
        return null;
    }

    public function buildUri() : self
    {
        return $this;
    }

    public function buildMethod() : self
    {
        return $this;
    }

    public function buildBody() : self
    {
        return $this;
    }

    public function buildQuery() : self
    {
        return $this;
    }

    public function buildHeaders() : self
    {
        return $this;
    }

    public function buildFiles() : self
    {
        return $this;
    }
}
