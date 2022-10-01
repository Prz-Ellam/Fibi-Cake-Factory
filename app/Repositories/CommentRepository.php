<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Comment;
use Fibi\Database\DB;

class CommentRepository
{
    private const CREATE = "CALL sp_create_comment(:commentId, :message, :productId, :userId)";
    private const UPDATE = "";
    private const DELETE = "";
    private const GET_ALL_BY_PRODUCT = "CALL sp_comments_get_all_by_product(:productId)";

    public function create(Comment $comment) : bool
    {
        return DB::executeNonQuery(self::CREATE, [
            "commentId" => $comment->getCommentId(),
            "message" => $comment->getMessage(),
            "productId" => $comment->getProductId(),
            "userId" => $comment->getUserId()
        ]) > 0;
    }

    public function update(Comment $comment) : bool
    {
        return false;
    }

    public function delete(string $commentId) : bool
    {
        return false;
    }

    public function getAllByProduct(string $productId) : array
    {
        return DB::executeReader(self::GET_ALL_BY_PRODUCT, [
            "productId" => $productId
        ]);
    }
}

?>