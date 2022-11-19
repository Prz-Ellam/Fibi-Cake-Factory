<?php

namespace Fibi\Http;

use Fibi\Helpers\UploadedFile;
use Fibi\Routing\Route;
use Fibi\Session\Session;

class Request
{
    /**
     * Contiene la Uri que fue solicitada
     *
     * @var string
     */
    private string $uri;

    /**
     * Contiene el método Http que fue solicitado
     *
     * @var HttpMethod
     */
    private HttpMethod $method;

    /**
     * Arreglo asociativo con el cuerpo de la petición
     *
     * @var array<string, string>
     */
    private array $body;

    /**
     * Arreglo asociativo con los query params de la petición
     *
     * @var array<string, string>
     */
    private array $query;

    /**
     * Arreglo asociativo con las cabeceras de la petición
     *
     * @var array<string, string>
     */
    private array $headers;

    /**
     * Ruta solicitada
     *
     * @var Route|null
     */
    private ?Route $route;

    /**
     * Arreglos asociativo con los archivos de la petición
     *
     * @var array
     */
    private array $files;

    public function __construct() {
        
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    public function setUri(string $uri) : self
    {
        $this->uri = $uri;
        return $this;
    }

    public function getMethod() : HttpMethod
    {
        return $this->method;
    }

    public function setMethod(HttpMethod $method) : self
    {
        $this->method = $method;
        return $this;
    }

    public function getBody(?string $key = null) : array|string|null
    {
        if (is_null($key))
        {
            return $this->body ?? null;
        }
        
        return $this->body[$key] ?? null;
    }

    public function setBody(array $body) : self
    {
        $this->body = $body;
        return $this;
    }

    public function getQuery(?string $key = null) : array|string|null
    {
        if (is_null($key))
        {
            return $this->query ?? null;
        }

        return $this->query[$key] ?? null;
    }

    public function setQuery(array $query) : self
    {
        $this->query = $query;
        return $this;
    }

    public function getHeaders(?string $key = null) : array|string|null
    {
        if (is_null($key))
        {
            return $this->headers;
        }

        return $this->headers[$key] ?? null;
    }

    public function setHeaders(array $headers) : self
    {
        $this->headers = $headers;
        return $this;
    }

    public function getRoute() : ?Route
    {
        return $this->route;
    }

    public function setRoute(?Route $route) : self
    {
        $this->route = $route;
        return $this;
    }

    public function getRouteParams(?string $key = null) : array|string|null
    {
        if (is_null($key))
        {
            return $this->route->getParameters($this->uri);
        }

        return $this->route->getParameters($this->uri)[$key] ?? null;
    }

    /**
     * TODO: Esto deberia ser aqui?
     *
     * @param array $files
     * @return self
     */
    public function setFiles(array $files) : self
    {
        $this->files = $files;
        return $this;
    }

    public function getFile(?string $key = null) : UploadedFile
    {
        if (is_null($key))
        {
            return $this->files;
        }

        return $this->files[$key] ?? null;
    }

    public function getFiles(?string $key = null): UploadedFile|array|null
    {
        if (is_null($key))
        {
            return $this->files ?? [];
        }

        return $this->files[$key] ?? [];
    }

    public function getFileArray(string $key)
    {
        $rawImages = $this->files[$key] ?? null;
        if (!$rawImages)
        {
            return [];
        }
        //$rawImages = $this->getFile($key);

        if (is_string($rawImages["name"]))
        {
            return [ $rawImages ];
        }

        if (is_null($rawImages["name"]))
        {
            return [];
        }

        if ($rawImages["name"][0] === "")
        {
            return [];
        }

        $images = [];
        for ($i = 0; $i < count($rawImages["name"]); $i++)
        {
            $images[$i]["name"] = $rawImages["name"][$i];
            $images[$i]["full_path"] = $rawImages["full_path"][$i];
            $images[$i]["type"] = $rawImages["type"][$i];
            $images[$i]["tmp_name"] = $rawImages["tmp_name"][$i];
            $images[$i]["error"] = $rawImages["error"][$i];
            $images[$i]["size"] = $rawImages["size"][$i];
        }

        $finalImages = [];
        foreach ($images as $imageCurrent)
        {
            $finalImages[] = new UploadedFile(
                $imageCurrent["name"] ?? null,
                $imageCurrent["path"] ?? null,
                $imageCurrent["tmp_name"] ?? null,
                $imageCurrent["size"] ?? null,
                $imageCurrent["type"] ?? null
            );
        }

        return $finalImages;
    }

    public function hasFile(string $key) : bool
    {
        return isset($this->files[$key]);
    }
}
