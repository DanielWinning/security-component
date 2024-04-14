<?php

namespace Luma\SecurityComponent\Authorization;

use Luma\AuroraDatabase\Attributes\AuroraCollection;
use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;

#[Schema('Security')]
#[Table('tblRole')]
class Role extends Aurora
{
    #[Identifier]
    #[Column('intRoleId')]
    protected int $id;

    #[Column('strRoleName')]
    private string $name;

    #[Column('strRoleHandle')]
    private string $handle;

    #[AuroraCollection(Role::class, null, 'Security', 'tblUserRole')]
    private Collection $permissions;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }

    /**
     * @param string|Permission $permission
     *
     * @return bool
     */
    public function hasPermission(string|Permission $permission): bool
    {
        return $this->permissions->find(function (Permission $rolePermission) use ($permission) {
            if ($permission instanceof Permission) {
                return ($rolePermission->getName() === $permission->getName());
            }

            return $rolePermission->getName() === $permission;
        });
    }
}