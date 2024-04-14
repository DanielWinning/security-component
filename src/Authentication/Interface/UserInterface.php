<?php

namespace Luma\SecurityComponent\Authentication\Interface;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\Role;

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
     * @param Role|string $role
     *
     * @return bool
     */
    public function hasRole(Role|string $role): bool;
}