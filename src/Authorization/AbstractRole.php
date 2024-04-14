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

    abstract public function getName(): string;

    abstract public function getHandle(): string;

    abstract public function getPermissions(): Collection;
}