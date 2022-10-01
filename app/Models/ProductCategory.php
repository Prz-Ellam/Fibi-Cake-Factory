<?php

namespace CakeFactory\Models;

use Fibi\Model\Model;
use Fibi\Validation\Rules\Required;
use Fibi\Validation\Rules\Uuid;

class ProductCategory implements Model
{
    #[Required]
    #[Uuid]
    private ?string $productCategoryId;

    #[Required]
    #[Uuid]
    private ?string $productId;
    
    #[Required]
    #[Uuid]
    private ?string $categoryId;

    public function getProductCategoryId()
    {
        return $this->productCategoryId;
    }

    public function setProductCategoryId(?string $productCategoryId) : self
    {
        $this->productCategoryId = $productCategoryId;
        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId(?string $productId) : self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId(?string $categoryId) : self
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    // TODO: array|null
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