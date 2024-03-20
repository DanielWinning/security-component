<?php

namespace Luma\SecurityComponent\Authentication;

class Password
{
    /**
     * @param string $password
     *
     * @return string
     */
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}