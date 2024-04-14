<?php

namespace Luma\SecurityComponent\Authentication\Interface;

interface SessionManagerInterface
{
    public static function start(): void;
    public static function setSessionItem(string $key, mixed $value): void;
    public static function getSessionItem(string $key): mixed;
    public static function end(): void;
}