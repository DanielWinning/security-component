<?php

namespace Luma\SecurityComponent\Authentication\Interface;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\AbstractRole;

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
     * @param AbstractRole|string $role
     *
     * @return bool
     */
    public function hasRole(AbstractRole|string $role): bool;
}