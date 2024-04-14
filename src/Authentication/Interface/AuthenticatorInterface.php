<?php

namespace Luma\SecurityComponent\Authentication\Interface;

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

    /**
     * @param string|null $redirectPath
     *
     * @return void
     */
    public function logout(string $redirectPath = null): void;
}