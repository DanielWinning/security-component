<?php

namespace Luma\SecurityComponent\Authorization\Interface;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authorization\AbstractPermission;

interface RoleInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getHandle(): string;

    /**
     * @return Collection
     */
    public function getPermissions(): Collection;

    /**
     * @return bool
     */
    public function hasPermission(AbstractPermission|string $permission): bool;
}