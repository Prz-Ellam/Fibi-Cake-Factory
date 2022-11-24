<?php

namespace CakeFactory\Repositories;

use CakeFactory\Models\User;
use Fibi\Database\DB;

class UserRepository
{
    private const CREATE = "CALL sp_users_create(:userId, :email, :username, :firstName, :lastName, :birthDate, :password, :gender, :visible, :userRole, :profilePicture)";
    private const UPDATE = "CALL sp_users_update(:userId, :email, :username, :firstName, :lastName, :birthDate, :gender, :profilePicture)";
    private const UPDATE_USER_PASSWORD = "CALL sp_users_update_password(:userId, :password)";
    private const DELETE = "CALL sp_users_delete(:userId)";
    private const GET_ONE = "CALL sp_get_user(:userId)";
    private const GET_ALL_EXCEPT = "CALL sp_get_users_except(:search, :userId)";
    private const GET_ALL_BY_FILTER = "CALL sp_get_user_by_filter(:filter, :except)";
    private const IS_USERNAME_AVAILABLE = "CALL sp_username_exists(:userId, :username)";
    private const IS_EMAIL_AVAILABLE = "CALL sp_email_exists(:userId, :email)";
    // GET_ALL
    // SEARCH

    public function create(User $user) : bool
    {
        return DB::executeNonQuery(self::CREATE, [
            "userId"            => $user->getUserId(),
            "email"             => $user->getEmail(),
            "username"          => $user->getUsername(),
            "firstName"         => $user->getFirstName(),
            "lastName"          => $user->getLastName(),
            "birthDate"         => $user->getBirthDate(),
            "password"          => $user->getPassword(),
            "gender"            => $user->getGender(),
            "visible"           => $user->isVisible(),
            "userRole"          => $user->getUserRole(),
            "profilePicture"    => $user->getProfilePicture()
        ]) > 0;
    }

    public function update(User $user) : bool
    {
        return DB::executeNonQuery(self::UPDATE, [
            "userId"            => $user->getUserId(),
            "email"             => $user->getEmail(),
            "username"          => $user->getUsername(),
            "firstName"         => $user->getFirstName(),
            "lastName"          => $user->getLastName(),
            "birthDate"         => $user->getBirthDate(),
            "gender"            => $user->getGender(),
            "profilePicture"    => $user->getProfilePicture()
        ]) > 0;
    }

    public function updatePassword(string $userId, string $password)
    {
        return DB::executeNonQuery(self::UPDATE_USER_PASSWORD, [
            "userId"            => $userId,
            "password"          => $password
        ]) > 0;
    }

    public function delete(string $userId) : bool
    {
        return DB::executeNonQuery(self::DELETE, [
            "userId"            => $userId
        ]) > 0;
    }

    public function getOne(string $userId) : array
    {
        $result = DB::executeReader(self::GET_ONE, [
            "userId" => $userId
        ]);

        return $result[0] ?? [];
    }

    public function getAllExcept(string $userId, string $search = "") : array
    {
        $result = DB::executeReader(self::GET_ALL_EXCEPT, [
            "userId" => $userId,
            "search" => $search
        ]);
        return $result;
    }

    public function getAllByFilter(string $filter, string $except = "")
    {
        return DB::executeReader(self::GET_ALL_BY_FILTER, [
            "filter" => $filter,
            "except" => $except
        ]);
    }

    public function isUsernameAvailable(string $userId, string $username)
    {
        return DB::executeReader(self::IS_USERNAME_AVAILABLE, [
            "userId"    => $userId,
            "username"  => $username
        ])[0] ?? [];
    }

    public function isEmailAvailable(string $userId, string $email)
    {
        return DB::executeReader(self::IS_EMAIL_AVAILABLE, [
            "userId"    => $userId,
            "email"     => $email
        ])[0] ?? [];
    }

}
