<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Attributes\SecurityIdentifier;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authorization\Interface\RoleInterface;

abstract class AbstractUser extends Aurora implements UserInterface
{
    protected int $id;
    protected string $username;
    protected string $password;

    abstract public function getUsername(): string;

    abstract public function getPassword(): string;

    abstract public function getRoles(): Collection;

    /**
     * @param RoleInterface|string $role
     *
     * @return bool
     */
    public function hasRole(RoleInterface|string $role): bool
    {
        return (bool) $this->getRoles()->find(function (RoleInterface $userRole) use ($role) {
            if ($role instanceof RoleInterface) {
                return $role->getId() === $userRole->getId();
            }

            return $role === $userRole->getHandle();
        });
    }

    /**
     * @param RoleInterface $role
     *
     * @return void
     */
    public function addRole(RoleInterface $role): void
    {
        $this->getRoles()->add($role);
    }

    /**
     * @return string
     */
    public static function getSecurityIdentifier(): string
    {
        $reflectionClass = new \ReflectionClass(static::class);

        foreach ($reflectionClass->getProperties() as $property) {
            $attribute = $property->getAttributes(SecurityIdentifier::class);

            if (!count($attribute)) {
                continue;
            }

            return $property->getName();
        }

        return '';
    }
}