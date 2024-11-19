<?php

namespace Luma\SecurityComponent\Entity;

use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\SecurityComponent\Authorization\AbstractPermission;

#[Schema('Security')]
#[Table('ublPermission')]
class Permission extends AbstractPermission
{
    #[Identifier]
    #[Column('intPermissionId')]
    protected int $id;

    #[Column('strPermissionName')]
    protected string $name;

    #[Column('strPermissionHandle')]
    protected string $handle;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return $this->handle;
    }
}