<?php

namespace CakeFactory\Models;

class ProductCategory
{
    private ?string $productCategoryId;
    private ?string $productId;
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
}

?>