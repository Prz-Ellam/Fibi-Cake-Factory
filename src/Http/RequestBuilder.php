<?php

namespace Fibi\Http;

use Fibi\Http;
use Fibi\Http\Request;

abstract class RequestBuilder
{
    public static function createFromPhpServer() : Request
    {
        return (new Request())
            ->setUri(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH))
            ->setMethod(HttpMethod::from($_SERVER["REQUEST_METHOD"]))
            ->setBody($_POST)
            ->setQuery($_GET)
            ->setHeaders(getallheaders())
            ->setFiles($_FILES);
    }

    public static function createFromMockup() : Request|null
    {
        return null;
    }
}

?>