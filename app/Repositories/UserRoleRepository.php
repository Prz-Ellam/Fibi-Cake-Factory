<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\UserRole;
use Fibi\Database\DB;

class UserRoleRepository
{
    private const CREATE = "CALL sp_create_user_role(:userRoleId, :name)";
    private const GET_ONE_BY_NAME = "CALL sp_get_user_role_by_name(:name)";

    public function create(UserRole $userRole) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "userRoleId" => $userRole->getUserRoleId(),
            "name" => $userRole->getName()
        ]);
        return $result > 0;
    }

    public function getOneByName(string $name) : array
    {
        $result = DB::executeReader(self::GET_ONE_BY_NAME, [
            "name" => $name
        ]);
        return $result[0] ?? [];
    }
}
