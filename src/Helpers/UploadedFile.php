<?php

namespace Fibi\Helpers;

class UploadedFile
{
    private ?string $name;
    private ?string $path;
    private ?string $tmpName;
    private ?int $size;
    private ?string $type;

    // TODO: clase concreta
    public function __construct(?string $name, ?string $path, ?string $tmpName, ?int $size, ?string $type)
    {
        $this->name = $name;
        $this->path = $path;
        $this->tmpName = $tmpName;
        $this->size = $size;
        $this->type = $type;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getPath() : ?string
    {
        return $this->path;
    }

    public function getTmpName() : ?string
    {
        return $this->tmpName;
    }

    public function getSize() : ?string
    {
        return $this->size;
    }

    public function getType() : ?string
    {
        return $this->type;
    }

    public function getContent() : mixed
    {
        $fileStatus = file_exists($this->tmpName ?? null);

        if ($fileStatus)
        {
            return file_get_contents($this->tmpName);
        }
        else
        {
            return null;
        }
    }
}
