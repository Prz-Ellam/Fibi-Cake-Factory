<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;

class Category implements Model
{
    /**
     * UUID con el identificador de la categoría
     *
     * @var string|null
     */
    #[Required]
    private ?string $categoryId;

    /**
     * Nombre de la categoría
     *
     * @var string|null
     */
    #[Required]
    private ?string $name;

    /**
     * Descripcion de la categoría
     *
     * @var string|null
     */
    private ?string $description;

    /**
     * UUID del identificador del usuario que creó la categoría
     *
     * @var string|null
     */
    #[Required]
    private ?string $userId;

    public function getCategoryId() : ?string
    {
        return $this->categoryId;
    }

    public function setCategoryId(?string $categoryId) : self
    {
        $this->categoryId = $categoryId;
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

    public function getDescription() : ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description) : self
    {
        $this->description = $description;
        return $this;
    }

    public function getUserId() : ?string
    {
        return $this->userId;
    }

    public function setUserId(?string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    public function toObject() : array
    {
        $members = get_object_vars($this);
        return json_decode(json_encode($members), true);
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}

?>