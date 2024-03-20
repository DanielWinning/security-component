<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\SecurityComponent\Interface\AuthenticatorInterface;
use Luma\SecurityComponent\Interface\UserProviderInterface;

abstract class Authenticator implements AuthenticatorInterface
{
    protected UserProviderInterface $userProvider;

    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    abstract public function authenticate(string $username, string $password): bool;
}