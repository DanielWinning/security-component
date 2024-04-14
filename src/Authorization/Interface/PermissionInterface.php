<?php

namespace Luma\SecurityComponent\Authorization\Interface;

interface PermissionInterface
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
}