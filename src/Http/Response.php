<?php

namespace Fibi\Http;

use Fibi\Core\Application;

class Response
{
    private int $statusCode;
    
    /**
     * Undocumented variable
     *
     * @var array<string, string>
     */
    private array $headers;

    private ?string $body;

    public function __construct() {
        $this->statusCode = 200;
        $this->headers = [];
        $this->body = "";
    }

    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode) : self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setContentType(string $value) : self
    {
        $this->setHeader("Content-Type", $value);
        return $this;
    }

    public function setHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;
    }

    public function removeHeader(string $header)
    {
        unset($this->headers[$header]);
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function getbody() : ?string
    {
        return $this->body;
    }

    public function setbody(string $body) : self
    {
        $this->body = $body;
        return $this;
    }
    
    public function json(mixed $content) : self
    {
        $this->setContentType("application/json")
                ->setBody(json_encode($content));
        return $this;
    }

    public function text(string $content) : self
    {
        $this->setContentType("text/plain")
                ->setBody($content);
        return $this;
    }

    public function redirect(string $uri) : self
    {
        $this->setHeader("Location", $uri);
        return $this;
    }

    public function csv(array $content) : self
    {
        $this->setContentType("text/csv");
        $this->setHeader("Content-Disposition", "attachment; filename=export.csv");
        $this->setHeader("Pragma", "no-cache");
        $this->setHeader("Expires", "0");

        // TODO: Mal
        $output = fopen("php://output",'w') or die("Can't open php://output");
        fputcsv($output, array('id','name','description'));
        foreach($content as $element) {
            fputcsv($output, $element);
        }
        fclose($output) or die("Can't close php://output");
    }

    public function view(string $view, ?string $layout = null) : self
    {
        $content = Application::app()->viewEngine->render($view, $layout);

        $this->setContentType("text/html")
                ->setBody($content);
        return $this;
    }
}

?>