<?php

namespace Luma\SecurityComponent\Authentication\Interface;

interface UserProviderInterface
{
    public function loadUserByUsername(string $username): ?UserInterface;
}