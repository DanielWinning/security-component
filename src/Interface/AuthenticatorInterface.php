<?php

namespace Luma\SecurityComponent\Interface;

use Luma\SecurityComponent\Authentication\AuthenticationResult;

interface AuthenticatorInterface
{
    /**
     * @param UserProviderInterface $userProvider;
     */
    public function __construct(UserProviderInterface $userProvider);

    /**
     * @param string $username
     * @param string $password
     *
     * @return AuthenticationResult
     */
    public function authenticate(string $username, string $password): AuthenticationResult;
}