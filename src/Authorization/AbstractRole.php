<?php

namespace Luma\SecurityComponent\Authorization;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\Interface\RoleInterface;

abstract class AbstractRole extends Aurora implements RoleInterface
{
    protected int $id;
    protected string $name;
    protected string $handle;
    protected Collection $permissions;

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @return string
     */
    abstract public function getHandle(): string;

    /**
     * @return Collection
     */
    abstract public function getPermissions(): Collection;

    /**
     * @param AbstractPermission|string $permission
     *
     * @return bool
     */
    public function hasPermission(AbstractPermission|string $permission): bool
    {
        return (bool) $this->permissions->find(function (AbstractPermission $rolePermission) use ($permission) {
            if ($permission instanceof AbstractPermission) {
                return $permission->getHandle() === $rolePermission->getHandle();
            }

            return $permission === $rolePermission->getHandle();
        });
    }

    /**
     * @param AbstractPermission $permission
     *
     * @return void
     */
    public function addPermission(AbstractPermission $permission): void
    {
        $this->permissions->add($permission);
    }
}