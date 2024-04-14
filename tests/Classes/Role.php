<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\AuroraCollection;
use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\AbstractRole;

#[Schema('Security')]
#[Table('tblRole')]
class Role extends AbstractRole
{
    #[Identifier]
    #[Column('intRoleId')]
    protected int $id;

    #[Column('strRoleName')]
    protected string $name;

    #[Column('strRoleHandle')]
    protected string $handle;

    #[AuroraCollection(class: Permission::class, pivotSchema: 'Security', pivotTable: 'tblPermissionRole')]
    protected Collection $permissions;

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
}