<?php

namespace Luma\SecurityComponent\Session;

use Luma\SecurityComponent\Authentication\Interface\SessionManagerInterface;

class DatabaseSessionManager implements SessionManagerInterface
{
    /**
     * @return void
     */
    public static function start(): void
    {
        session_start();
    }

    /**
     * @return void
     */
    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public static function setSessionItem(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function getSessionItem(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @return void
     */
    public static function end(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}