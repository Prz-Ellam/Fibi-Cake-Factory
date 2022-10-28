<?php

namespace CakeFactory\Repositories;

class QuoteRepository
{
    private const CREATE = "CALL sp_quotes_create(:quoteId, :sellerId, :shopperId, :productId, :price)";
    private const UPDATE = "CALL sp_quotes_update(:quoteId, :price)";
    private const DELETE = "CALL sp_quotes_delete(:quoteId)";
}
