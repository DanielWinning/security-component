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
        ini_set('session.gc_maxlifetime', 7200);
        ini_set('session.cookie_lifetime', 7200);

        session_set_cookie_params([
            'lifetime' => 7200,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    /**
     * @param bool $deleteOldSession
     *
     * @return void
     */
    public static function regenerate(bool $deleteOldSession = true): void
    {
        session_regenerate_id($deleteOldSession);
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