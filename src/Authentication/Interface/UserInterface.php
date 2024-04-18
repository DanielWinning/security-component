<?php

namespace Luma\SecurityComponent\Authentication\Interface;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\Interface\RoleInterface;

interface UserInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * Returns the hashed password.
     *
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return Collection
     */
    public function getRoles(): Collection;

    /**
     * @param RoleInterface|string $role
     *
     * @return bool
     */
    public function hasRole(RoleInterface|string $role): bool;

    /**
     * @return string
     */
    public static function getSecurityIdentifier(): string;

    /**
     * @param RoleInterface $role
     *
     * @return void
     */
    public function addRole(RoleInterface $role): void;
}