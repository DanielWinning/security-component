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

    /**
     * Generates a random password of the desired length. Be sure to display this password if you're generating
     * one for a user.
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandom(int $length = 12): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\@*&^%$£!(){}[]:;-_';
        $characterCount = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $characterCount - 1)];
        }

        return $randomPassword;
    }
}