<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Quote;
use Fibi\Database\DB;

class QuoteRepository
{
    private const CREATE = "CALL sp_quotes_create(:quoteId, :userId, :productId)";
    private const UPDATE = "CALL sp_quotes_update(:quoteId, :price)";
    private const DELETE = "CALL sp_quotes_delete(:quoteId)";
    private const GET_USER_ALL_PENDING = "CALL sp_quotes_get_user_pending(:userId)";

    public function create(Quote $quote) {

        return DB::executeNonQuery(self::CREATE, [
            "quoteId"       => $quote->getQuoteId(),
            "userId"        => $quote->getUserId(),
            "productId"     => $quote->getProductId()
        ]) > 0;

    }

    public function getUserAllPending(string $userId) {

        return DB::executeReader(self::GET_USER_ALL_PENDING, [
            "userId"        => $userId
        ]);

    }
}
