<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\Comment;

class CommentRepository
{
    private const CREATE = "";
    private const UPDATE = "";
    private const DELETE = "";
    private const GET_ALL_BY_PRODUCT = "";

    public function create(Comment $comment) : bool
    {
        return false;
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
        return [];
    }
}

?>