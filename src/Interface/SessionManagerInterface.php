<?php

namespace Luma\SecurityComponent\Interface;

interface SessionManagerInterface
{
    public static function start(): void;
    public static function setSessionItem(string $key, int|string $value): void;
    public static function getSessionItem(string $key): int|string|null;
    public static function end(): void;
}