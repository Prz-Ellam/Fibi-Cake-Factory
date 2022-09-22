<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Image extends Model
{
    private ?string $imageId;
    private ?string $name;
    private ?int $size;
    private mixed $content;
    private ?string $type;
    private ?string $multimediaEntityId;
    private ?string $multimediaEntityType;

    public function getImageId() : ?string
    {
        return $this->imageId;
    }

    public function setImageId(?string $imageId) : self
    {
        $this->imageId = $imageId;
        return $this;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(?string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function getSize() : ?int
    {
        return $this->size;
    }

    public function setSize(?int $size) : self
    {
        $this->size = $size;
        return $this;
    }

    public function getContent() : mixed
    {
        return $this->content;
    }

    public function setContent(mixed $content) : self
    {
        $this->content = $content;
        return $this;
    }

    public function getType() : ?string
    {
        return $this->type;
    }

    public function setType(?string $type) : self
    {
        $this->type = $type;
        return $this;
    }

    public function getMultimediaEntityId() : ?string
    {
        return $this->multimediaEntityId;
    }

    public function setMultimediaEntityId(?string $multimediaEntityId) : self
    {
        $this->multimediaEntityId = $multimediaEntityId;
        return $this;
    }

    public function getMultimediaEntityType() : ?string
    {
        return $this->multimediaEntityType;
    }

    public function setMultimediaEntityType(?string $multimediaEntityType) : self
    {
        $this->multimediaEntityType = $multimediaEntityType;
        return $this;
    }
}

?>