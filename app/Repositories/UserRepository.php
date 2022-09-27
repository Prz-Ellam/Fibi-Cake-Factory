<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\User;
use Fibi\Database\DB;

class UserRepository
{
    private const CREATE = "CALL sp_create_user(:userId, :email, :username, :firstName, 
        :lastName, :birthDate, :password, :gender, :visibility, :userRole, :profilePicture)";
    private const UPDATE_USER = "CALL sp_update_user(?)";
    private const UPDATE_USER_PASSWORD = "CALL sp_update_user_password(?)";
    private const DELETE_USER = "CALL sp_delete_user(?)";
    private const LOGIN = "CALL login(:loginOrEmail, :password)";
    private const GET_USER = "CALL sp_get_user(:userId)";
    // GET_ALL
    // SEARCH

    public function create(User $user) : bool
    {
        $result = DB::executeNonQuery(self::CREATE, [
            "userId"            => $user->getUserId(),
            "email"             => $user->getEmail(),
            "username"          => $user->getUsername(),
            "firstName"         => $user->getFirstName(),
            "lastName"          => $user->getLastName(),
            "birthDate"         => $user->getBirthDate(),
            "password"          => $user->getPassword(),
            "gender"            => $user->getGender(),
            "visibility"        => $user->getVisibility(),
            "userRole"          => $user->getUserRole(),
            "profilePicture"    => $user->getProfilePicture()
        ]);

        return $result > 0;
    }

    public function update(User $user) : bool
    {
        DB::executeNonQuery(self::UPDATE_USER, []);
        return true;
    }

    public function delete(int $id) : bool
    {
        return true;
    }

    public function getUser(string $userId) : array
    {
        $result = DB::executeReader(self::GET_USER, [
            "userId" => $userId
        ]);

        return $result;
    }

    public function login(string $loginOrEmail, string $password)
    {
        
    }
}

?>