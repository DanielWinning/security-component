<?php

namespace Luma\SecurityComponent\Authorization\Interface;

use Luma\AuroraDatabase\Utils\Collection;

interface RoleInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getHandle(): string;
    public function getPermissions(): Collection;
}