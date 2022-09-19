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

    public function setStatusCode(int $statusCode) : void
    {
        $this->statusCode = $statusCode;
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
    
    public function json(array $content)
    {
        $this->setContentType("application/json")
                ->setBody(json_encode($content));
    }

    public function text(string $content)
    {
        $this->setContentType("text/plain")
                ->setBody($content);
    }

    public function redirect(string $uri)
    {
        $this->setHeader("Location", $uri);
    }

    public function view(string $view)
    {
        $content = Application::app()->viewEngine->render($view);

        $this->setContentType("text/html")
                ->setBody($content);
    }
}

?>