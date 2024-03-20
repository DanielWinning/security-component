<?php

namespace Luma\SecurityComponent\Interface;

interface UserInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * Returns the hashed password.
     *
     * @return string
     */
    public function getPassword(): string;
}