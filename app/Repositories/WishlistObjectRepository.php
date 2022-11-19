<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\WishlistObject;
use Fibi\Database\DB;
use Fibi\Helpers\Parser;

class WishlistObjectRepository
{
    private const CREATE = "CALL sp_wishlist_objects_create(:wishlistObjectId, :wishlistId, :productId)";
    private const DELETE = "CALL sp_delete_wishlist_object(:wishlistObjectId)";
    private const GET_ALL_BY_WISHLIST = "CALL sp_get_wishlist_objects(:wishlistId)";
    private const GET_USER_ID = "CALL sp_wishlist_objects_get_user_id(:wishlistObjectId)";

    public function create(WishlistObject $wishlistObject)
    {
        return DB::executeNonQuery(self::CREATE, [
            "wishlistObjectId"      => $wishlistObject->getWishlistObjectId(),
            "wishlistId"            => $wishlistObject->getWishlistId(),
            "productId"             => $wishlistObject->getProductId()
        ]) > 0;
    }

    public function delete(string $wishlistObjectId)
    {
        return DB::executeNonQuery(self::DELETE, [
            "wishlistObjectId"      => $wishlistObjectId
        ]) > 0;
    }

    public function getWishlistObjects(string $wishlistId)
    {
        $result = DB::executeReader(self::GET_ALL_BY_WISHLIST, [
            "wishlistId"            => $wishlistId
        ]);

        return $result;
    }

    public function getWishlistObjectUserId(string $wishlistObjectId)
    {
        $result = DB::executeReader(self::GET_USER_ID, [
            "wishlistObjectId" => $wishlistObjectId
        ]);

        return $result[0]["user_id"] ?? "";
    }
}
