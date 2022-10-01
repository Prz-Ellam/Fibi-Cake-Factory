<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;

class Video implements Model
{
    #[Required]
    private ?string $videoId;

    #[Required]
    private ?string $name;

    #[Required]
    private ?int $size;

    #[Required]
    private mixed $content;

    #[Required]
    private ?string $type;

    #[Required]
    private ?string $multimediaEntityId;

    #[Required]
    private ?string $multimediaEntityType;

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

    public function getMultimediaEntityType() : ?string
    {
        return $this->multimediaEntityType;
    }

    public function setMultimediaEntityType(?string $multimediaEntityType) : self
    {
        $this->multimediaEntityType = $multimediaEntityType;
        return $this;
    }

    public function toObject() : array
    {
        $members = get_object_vars($this);
        return $members;
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}

?>