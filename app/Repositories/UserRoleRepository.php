<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\UserRole;
use Fibi\Database\DB;

class UserRoleRepository
{
    private const CREATE = "CALL sp_create_user_role(:userRoleId, :name)";

    public function create(UserRole $userRole) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "userRoleId" => $userRole->getUserRoleId(),
            "name" => $userRole->getName()
        ]);
        return $result > 0;
    }
}
