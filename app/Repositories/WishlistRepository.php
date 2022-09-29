<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Wishlist;
use Fibi\Database\DB;
use Fibi\Helpers\Parser;

class WishlistRepository
{
    private const CREATE = "CALL sp_create_wishlist(:wishlistId, :name, :description, :visible, :userId)";
    private const UPDATE = "CALL sp_update_wishlist(:wishlistId, :name, :description, :visible)";
    private const DELETE = "CALL sp_delete_wishlist(:wishlistId)";
    private const GET_ALL_BY_USER = "CALL sp_get_user_wishlists(:userId, :count, :offset)";
    private const GET_ALL_BY_USER_PUBLIC = "CALL get_all_by_user_public(:userId, :count, :offset)";
    private const GET_ONE = "CALL sp_get_wishlist(:wishlistId)";

    public function create(Wishlist $wishlist)
    {
        $parameters = Parser::SP(self::CREATE);
        $result = DB::executeNonQuery(self::CREATE, $wishlist->toObject($parameters));
        return $result > 0;
    }

    public function update(Wishlist $wishlist)
    {
        $result = DB::executeNonQuery(self::UPDATE, [
            "wishlistId"        => $wishlist->getWishlistId(),
            "name"              => $wishlist->getName(),
            "description"       => $wishlist->getDescription(),
            "visibility"        => $wishlist->getVisibility()
            //"userId"            => $wishlist->getUserId()
        ]);

        return $result > 0;
    }

    public function delete(string $wishlistId)
    {
        $result = DB::executeNonQuery(self::DELETE, [
            "wishlistId"        => $wishlistId
        ]);

        return $result > 0;
    }

    public function getWishlist(string $wishlistId)
    {
        $result = DB::executeReader(self::GET_ONE, [
            "wishlistId"        => $wishlistId
        ]);

        return $result;
    }

    public function getUserWishlists(string $userId, int $count, int $offset) : array
    {
        $result = DB::executeReader(self::GET_ALL_BY_USER, [
            "userId"        => $userId,
            "count"         => $count,
            "offset"        => $offset
        ]);

        return $result;
    }

    public function getUserWishlistsPubli(string $userId, int $count, int $offset) : array
    {
        return [];
    }
}

?>