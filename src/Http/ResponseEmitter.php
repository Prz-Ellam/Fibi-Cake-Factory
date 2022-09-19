<?php

namespace Fibi\Http;

class ResponseEmitter
{
    public function emitResponse(Response $response)
    {
        http_response_code($response->getStatusCode());
        foreach ($response->getHeaders() as $key => $value)
        {
            header("$key: $value");
        }
        header("Content-Length: " . strlen($response->getBody()));

        print($response->getBody());
    }
}

?>