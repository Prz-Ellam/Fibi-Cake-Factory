<?php

namespace Fibi\Helpers;

class UploadedFile
{
    private string $name;
    private string $path;
    private string $tmpName;
    private int $size;
    private string $type;

    // TODO: clase concreta
    public function __construct(string $name, string $path, string $tmpName, string $size, string $type)
    {
        $this->name = $name;
        $this->path = $path;
        $this->tmpName = $tmpName;
        $this->size = $size;
        $this->type = $type;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getPath() : string
    {
        return $this->path;
    }
}
