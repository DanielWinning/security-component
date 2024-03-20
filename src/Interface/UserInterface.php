<?php

namespace Luma\SecurityComponent\Interface;

interface UserInterface
{
    public function getId(): int;
    public function getUsername(): string;
    public function getPassword(): string;

    /**
     * Must return the name of the username property on the implementing class.
     *
     * @return string
     */
    public static function getUsernameProperty(): string;
}