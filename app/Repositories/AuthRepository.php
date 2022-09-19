<?php

namespace CakeFactory\Repositories;

use Fibi\Database\MainConnection;

class AuthRepository
{
    private MainConnection $connection;
    private const LOGIN = "CALL sp_login(:loginOrEmail)";

    public function __construct() {
        $this->connection = new MainConnection();
    }

    public function login(string $loginOrEmail)
    {
        $result = $this->connection->executeReader(self::LOGIN, [
            "loginOrEmail" => $loginOrEmail
        ]);

        return $result;
    }
}

?>