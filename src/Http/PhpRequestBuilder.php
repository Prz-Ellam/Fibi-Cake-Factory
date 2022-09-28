<?php

namespace Fibi\Http;

class PhpRequestBuilder extends RequestBuilder
{
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

?>