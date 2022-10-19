<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;
use Fibi\Validation\Rules\MaxLength;

class Category implements Model
{
    /**
     * UUID con el identificador de la categoría
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $categoryId = null;

    /**
     * Nombre de la categoría
     *
     * @var string|null
     */
    #[Required]
    #[MaxLength(50)]
    private ?string $name = null;

    /**
     * Descripcion de la categoría
     *
     * @var string|null
     */
    #[MaxLength(200)]
    private ?string $description = null;

    /**
     * UUID del identificador del usuario que creó la categoría
     *
     * @var string|null
     */
    #[Required]
    #[Uuid]
    private ?string $userId = null;

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

    public function toObject(array $bind = null) : array
    {
        $members = get_object_vars($this);
        $members = json_decode(json_encode($members), true);

        if (is_null($bind) || count($bind) === 0)
        {
            return $members;
        }

        $members = array_filter($members, 
        function($key) use ($bind) { 
            return in_array($key, $bind); 
        }, ARRAY_FILTER_USE_KEY);

        return $members;
    }

    public static function getProperties() : array
    {
        return array_keys(get_class_vars(self::class));
    }
}
