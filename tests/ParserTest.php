<?php

namespace Fibi\Tests;

use CakeFactory\Models\Category;
use Fibi\Helpers\Parser;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;

/**
 * @test
 */
class ParserTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @test
     */
    public function testStoredProcedure()
    {
        $v1 = "CALL sp_create_user(:userId, :email, :username, :firstName, :lastName, :birthDate, :password, :gender, :visible, :userRole, :profilePicture)";
        $parameters = Parser::SP($v1);
        $this->assertEquals([
            "userId", "email", "username", "firstName", "lastName", "birthDate", "password", "gender", "visible", "userRole", "profilePicture"
        ], $parameters);
        
        $v2 = "CALL sp_update_user(?)";
        $parameters = Parser::SP($v2);
        $this->assertEquals([], $parameters);

        $v5 = "CALL login(:loginOrEmail, :password)";
        $parameters = Parser::SP($v5);
        $this->assertEquals([
            "loginOrEmail", "password"
        ], $parameters);

        $v6 = "CALL sp_get_user(:userId)";
        $parameters = Parser::SP($v6);
        $this->assertEquals([
            "userId"
        ], $parameters);

        $v7 = "CALL sp_create_category(:categoryId, :name, :description, :userId)";
        $parameters = Parser::SP($v7);
        $this->assertEquals([
            "categoryId", "name", "description", "userId"
        ], $parameters);

        $v8 = "CALL sp_update_category(:categoryId, :name, :description)";
        $v9 = "CALL sp_delete_category(:categoryId)";
        $v10 = "CALL sp_get_categories()";

        $v11 = "CALL sp_create_product(:productId, :name, :description, :isQuotable, :price, :stock, :userId)";
        $parameters = Parser::SP($v11);
        $this->assertEquals([
            "productId", "name", "description", "isQuotable", "price", "stock", "userId"
        ], $parameters);

        $v12 = "CALL sp_update_product(:productId, :name, :description, :isQuotable, :price, :stock)";
        $v13 = "CALL sp_delete_product(:productId)";
        $v14 = "CALL sp_get_user_products(:userId)";
        $v15 = "CALL sp_get_product(:productId)";
        $v16 = "CALL sp_get_recent_products()";

        $v17 = "CALL sp_create_wishlist(:wishlistId, :name, :description, :visible, :userId)";
        $parameters = Parser::SP($v17);
        $this->assertEquals([
            "wishlistId", "name", "description", "visible", "userId"
        ], $parameters);

        $v18 = "CALL sp_update_wishlist(:wishlistId, :name, :description, :visibility)";
        $v19 = "CALL sp_delete_wishlist(:wishlistId)";
        $v20 = "CALL sp_get_user_wishlists(:userId, :count, :offset)";
        $parameters = Parser::SP($v20);
        $this->assertEquals([
            "userId", "count", "offset"
        ], $parameters);

        $v21 = "CALL sp_get_wishlist(:wishlistId)";
        
    }
}
