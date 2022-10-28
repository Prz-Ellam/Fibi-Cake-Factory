<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Comment;
use CakeFactory\Models\Review;
use Fibi\Database\DB;

class ReviewRepository
{
    private const CREATE = "CALL sp_reviews_create(:reviewId, :message, :rate, :productId, :userId)";
    private const UPDATE = "CALL sp_reviews_update(:reviewId, :message, :rate, :productId)";
    private const DELETE = "CALL sp_reviews_delete(:reviewId)";
    private const GET_ALL_BY_PRODUCT = "CALL sp_reviews_get_all_by_product(:productId)";

    public function create(Review $review) : bool
    {
        return DB::executeNonQuery(self::CREATE, [
            "reviewId" => $review->getReviewId(),
            "message" => $review->getMessage(),
            "rate" => $review->getRate(),
            "productId" => $review->getProductId(),
            "userId" => $review->getUserId()
        ]) > 0;
    }

    public function update(Review $comment) : bool
    {
        return false;
    }

    public function delete(string $reviewId) : bool
    {
        return DB::executeNonQuery(self::DELETE, [
            "reviewId" => $reviewId
        ]) > 0;
    }

    public function getAllByProduct(string $productId) : array
    {
        return DB::executeReader(self::GET_ALL_BY_PRODUCT, [
            "productId" => $productId
        ]);
    }
}

?>