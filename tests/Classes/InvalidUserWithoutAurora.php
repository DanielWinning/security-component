<?php

namespace Luma\Tests\Classes;

use Luma\SecurityComponent\Interface\UserInterface;

class InvalidUserWithoutAurora implements UserInterface
{
    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    public function getUsername(): string
    {
        // TODO: Implement getUsername() method.
    }

    public function getPassword(): string
    {
        // TODO: Implement getPassword() method.
    }

    public static function getUsernameProperty(): string
    {
        // TODO: Implement getUsernameProperty() method.
    }
}