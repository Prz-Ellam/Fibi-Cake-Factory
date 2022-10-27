<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Comment;
use CakeFactory\Models\Review;
use Fibi\Database\DB;

class ReviewRepository
{
    private const CREATE = "CALL sp_create_review(:reviewId, :message, :rate, :productId, :userId)";
    private const UPDATE = "CALL sp_reviews_update(:reviewId, :message, :rate, :productId)";
    private const DELETE = "CALL sp_reviews_delete(:reviewId)";
    private const GET_ALL_BY_PRODUCT = "CALL sp_reviews_get_all_by_product(:productId)";

    public function create(Review $comment) : bool
    {
        return DB::executeNonQuery(self::CREATE, [
            "reviewId" => $comment->getReviewId(),
            "message" => $comment->getMessage(),
            "rate" => $comment->getRate(),
            "productId" => $comment->getProductId(),
            "userId" => $comment->getUserId()
        ]) > 0;
    }

    public function update(Review $comment) : bool
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