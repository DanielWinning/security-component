<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authorization\Role;

abstract class AbstractUser extends Aurora implements UserInterface
{
    protected int $id;
    protected string $username;
    protected string $password;

    abstract public function getUsername(): string;

    abstract public function getPassword(): string;

    abstract public function getRoles(): Collection;

    /**
     * @param Role|string $role
     *
     * @return bool
     */
    public function hasRole(Role|string $role): bool
    {
        return (bool) $this->getRoles()->find(function (Role $userRole) use ($role) {
            if ($role instanceof Role) {
                return $role->getId() === $userRole->getId();
            }

            return $role === $userRole->getHandle();
        });
    }
}