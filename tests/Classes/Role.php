<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\AbstractRole;

class Role extends AbstractRole
{
    protected int $id;

    protected string $name;

    protected string $handle;

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