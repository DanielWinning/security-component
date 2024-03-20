<?php

namespace Luma\SecurityComponent\Interface;

interface UserProviderInterface
{
    public function loadById(int $id): ?UserInterface;

    public function loadUserByUsername(string $username): ?UserInterface;
}