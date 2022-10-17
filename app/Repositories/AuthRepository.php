<?php

namespace CakeFactory\Repositories;

use Fibi\Database\DB;

class AuthRepository
{
    private const LOGIN = "CALL sp_login(:loginOrEmail)";

    public function login(string $loginOrEmail)
    {
        $result = DB::executeReader(self::LOGIN, [
            "loginOrEmail" => $loginOrEmail
        ]);

        return $result[0] ?? [];
    }
}

?>