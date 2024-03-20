<?php

namespace Luma\SecurityComponent\Interface;

interface UserProviderInterface
{
    /**
     * @param int $id
     *
     * @return UserInterface|null
     */
    public function loadById(int $id): ?UserInterface;

    /**
     * @param string $username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername(string $username): ?UserInterface;
}