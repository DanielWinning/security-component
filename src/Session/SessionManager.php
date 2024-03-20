<?php

namespace Luma\SecurityComponent\Session;

use Luma\SecurityComponent\Interface\SessionManagerInterface;

class SessionManager implements SessionManagerInterface
{
    /**
     * @return void
     */
    public static function start(): void
    {
        session_start();
        session_regenerate_id(true);
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            session_id(),
            time() + $params['lifetime'],
            $params['path'],
            $params['domain'],
            true,
            true
        );
    }

    /**
     * @param string $key
     * @param int|string $value
     *
     * @return void
     */
    public static function setSessionItem(string $key, int|string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return int|string|null
     */
    public static function getSessionItem(string $key): int|string|null
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @return void
     */
    public static function end(): void
    {
        session_destroy();
    }
}