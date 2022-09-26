<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\WishlistObject;
use Fibi\Database\DB;

class WishlistObjectRepository
{
    private const CREATE = "CALL sp_add_wishlist_object(:wishlistObjectId, :wishlistId, :productId)";
    private const GET_WISHLIST_OBJECTS = "CALL sp_get_wishlist_objects(:wishlistId)";
    private const DELETE = "CALL sp_delete_wishlist_object(:wishlistObjectId)";

    public function create(WishlistObject $wishlistObject)
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "wishlistObjectId"      => $wishlistObject->getWishlistObjectId(),
            "wishlistId"            => $wishlistObject->getWishlistId(),
            "productId"             => $wishlistObject->getProductId()
        ]);

        return $result > 0;
    }

    public function delete(string $wishlistObjectId)
    {
        $result = DB::executeNonQuery(self::DELETE, [
            "wishlistObjectId"      => $wishlistObjectId
        ]);

        return $result > 0;
    }

    public function getWishlistObjects(string $wishlistId)
    {
        $result = DB::executeReader(self::GET_WISHLIST_OBJECTS, [
            "wishlistId"            => $wishlistId
        ]);

        return $result;
    }
}

?>