<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Wishlist;
use Fibi\Database\MainConnection;

class WishlistRepository
{
    private MainConnection $connection;
    private const CREATE_WISHLIST = "CALL sp_create_wishlist(:wishlistId, :name, :description, :visibility, :userId)";
    private const UPDATE_WISHLIST = "CALL sp_update_wishlist(:wishlistId, :name, :description, :visibility)";
    private const DELETE_WISHLIST = "CALL sp_delete_wishlist(:wishlistId)";
    private const GET_USER_WISHLISTS = "CALL sp_get_user_wishlists(:userId, :count, :offset)";
    private const GET_WISHLIST = "";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function create(Wishlist $wishlist)
    {
        $result = $this->connection->executeNonQuery(self::CREATE_WISHLIST, [
            "wishlistId"        => $wishlist->getWishlistId(),
            "name"              => $wishlist->getName(),
            "description"       => $wishlist->getDescription(),
            "visibility"        => $wishlist->getVisibility(),
            "userId"            => $wishlist->getUserId()
        ]);

        return $result > 0;
    }

    public function update(Wishlist $wishlist)
    {
        $result = $this->connection->executeNonQuery(self::UPDATE_WISHLIST, [
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
        $result = $this->connection->executeNonQuery(self::DELETE_WISHLIST, [
            "wishlistId"        => $wishlistId
        ]);

        return $result > 0;
    }

    public function getUserWishlists(string $userId, int $count, int $offset) : array
    {
        $result = $this->connection->executeReader(self::GET_USER_WISHLISTS, [
            "userId"        => $userId,
            "count"         => $count,
            "offset"        => $offset
        ]);

        return $result;
    }
}

?>