<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authorization\AbstractRole;

abstract class AbstractUser extends Aurora implements UserInterface
{
    protected int $id;
    protected string $username;
    protected string $password;

    abstract public function getUsername(): string;

    abstract public function getPassword(): string;

    abstract public function getRoles(): Collection;

    /**
     * @param AbstractRole|string $role
     *
     * @return bool
     */
    public function hasRole(AbstractRole|string $role): bool
    {
        return (bool) $this->getRoles()->find(function (AbstractRole $userRole) use ($role) {
            if ($role instanceof AbstractRole) {
                return $role->getId() === $userRole->getId();
            }

            return $role === $userRole->getHandle();
        });
    }

    /**
     * @param AbstractRole $role
     *
     * @return void
     */
    public function addRole(AbstractRole $role): void
    {
        $this->getRoles()->add($role);
    }
}