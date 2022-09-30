<?php

namespace Fibi\Helpers;

class Crypto
{
    public static function bcrypt(string $input) : string
    {
        return password_hash($input, PASSWORD_BCRYPT);
    }

    public static function verify(string $hash, string $input) : bool
    {
        return password_verify($hash, $input);
    }
}
