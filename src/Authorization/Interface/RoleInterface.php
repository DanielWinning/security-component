<?php

namespace Luma\SecurityComponent\Authorization\Interface;

use Luma\AuroraDatabase\Utils\Collection;

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
}