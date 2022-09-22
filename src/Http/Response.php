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
    
    public function json(array $content) : self
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

    public function view(string $view, ?string $layout = null) : self
    {
        $content = Application::app()->viewEngine->render($view, $layout);

        $this->setContentType("text/html")
                ->setBody($content);
        return $this;
    }
}

?>