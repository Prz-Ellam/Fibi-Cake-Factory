<?php

namespace Fibi\Tests;

use CakeFactory\Models\Category;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @test
 */
class ModelToObjectTest extends TestCase
{
    /**
     * Validat que la funcion toObject de los modelos funciona correctamente
     *
     * @test
     */
    public function modelToObject()
    {
        $categoryId = Uuid::uuid4()->toString();
        $userId = Uuid::uuid4()->toString();

        $category = new Category();
        $category
            ->setCategoryId($categoryId)
            ->setName("Chocolates")
            ->setDescription("Pasteles deliciosos")
            ->setUserId($userId);

        $bind = [ "categoryId" ];

        // TODO: que tambien acepte sueltos
        $params = $category->toObject($bind);

        $this->assertEquals([
            "categoryId" => $categoryId
        ], $params);


        $bind = [ "name", "description" ];
        $params = $category->toObject($bind);

        $this->assertEquals([
            "name" => "Chocolates",
            "description" => "Pasteles deliciosos"
        ], $params);

        $params = $category->toObject();
        $this->assertEquals([
            "categoryId" => $categoryId,
            "name" => "Chocolates",
            "description" => "Pasteles deliciosos",
            "userId" => $userId
        ], $params);

        $params = $category->toObject([]);
        $this->assertEquals([
            "categoryId" => $categoryId,
            "name" => "Chocolates",
            "description" => "Pasteles deliciosos",
            "userId" => $userId
        ], $params);


    }
}
