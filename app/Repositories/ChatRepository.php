<?php

namespace CakeFactory\Repositories;

use Fibi\Database\MainConnection;
use Fibi\Http\Controller;

class ChatRepository
{
    private MainConnection $connection;

    public function __construct()
    {
        $this->connection = new MainConnection();
    }

    public function create()
    {
        
    }
}

?>