<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authorization\AbstractRole;
use Luma\SecurityComponent\Authorization\Interface\RoleInterface;

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

    public function getRoles(): Collection
    {
        // TODO: Implement getRoles() method.
    }

    public function hasRole(RoleInterface|string $role): bool
    {
        // TODO: Implement hasRole() method.
    }

    public function addRole(RoleInterface $role): void
    {
        // TODO: Implement addRole() method.
    }

    public static function getSecurityIdentifier(): string
    {
        // TODO: Implement getSecurityIdentifier() method.
    }
}