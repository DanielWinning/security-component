<?php

namespace Luma\SecurityComponent\Authorization;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Authorization\Interface\PermissionInterface;

abstract class AbstractPermission extends Aurora implements PermissionInterface
{
    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @return string
     */
    abstract public function getHandle(): string;
}