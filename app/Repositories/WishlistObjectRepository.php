<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\WishlistObject;
use Fibi\Database\MainConnection;

class WishlistObjectRepository
{
    private MainConnection $connection;
    private const CREATE_WISHLIST_OBJECT = "CALL sp_add_wishlist_object(:wishlistObjectId, :wishlistId, :productId)";
    private const GET_WISHLIST_OBJECTS = "CALL sp_get_wishlist_objects(:wishlistId)";
    private const DELETE_WISHLIST_OBJECT = "CALL sp_delete_wishlist_object(:wishlistObjectId)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(WishlistObject $wishlistObject)
    {
        $result = $this->connection->executeNonQuery(self::CREATE_WISHLIST_OBJECT, [
            "wishlistObjectId"      => $wishlistObject->getWishlistObjectId(),
            "wishlistId"            => $wishlistObject->getWishlistId(),
            "productId"             => $wishlistObject->getProductId()
        ]);

        return $result > 0;
    }

    public function delete(string $wishlistObjectId)
    {
        $result = $this->connection->executeNonQuery(self::DELETE_WISHLIST_OBJECT, [
            "wishlistObjectId"      => $wishlistObjectId
        ]);

        return $result > 0;
    }

    public function getWishlistObjects(string $wishlistId)
    {
        $result = $this->connection->executeReader(self::GET_WISHLIST_OBJECTS, [
            "wishlistId"            => $wishlistId
        ]);

        return $result;
    }
}

?>