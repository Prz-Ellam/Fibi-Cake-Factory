<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;

class Video extends Model
{
    private ?string $videoId;
    private ?string $name;
    private ?int $size;
    private mixed $content;
    private ?string $type;
    private ?string $multimediaEntityId;

    public function getVideoId() : ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId) : self
    {
        $this->videoId = $videoId;
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
}

?>