<?php

namespace Fibi\Tests;

use CakeFactory\Models\Category;
use Fibi\Validation\Rules\Email;
use Fibi\Validation\Rules\Required;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

class ValidatorApiTest extends TestCase
{
    public function testEmail()
    {
        $email = new Email();
        $result = $email->isValid("PerezAlex088@outlook.com");
        $this->assertEquals(true, $result);

        $result = $email->isValid("a@a.com");
        $this->assertEquals(true, $result);
    }

    public function testRequired()
    {
        $required = new Required();
        $result = $required->isValid("");

        $this->assertEquals(false, $result);
    }

    //public function testCategory()
    //{
        /*
        $category = new Category();
        $category
            ->setCategoryId(Uuid::uuid4()->toString())
            ->setName("Chocolates")
            ->setDescription("Pasteles deliciosos")
            ->setUserId(Uuid::uuid4()->toString());

        */
    //}
}
