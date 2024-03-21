<?php

namespace Luma\SecurityComponent\Authentication\Authenticators;

use Luma\SecurityComponent\Authentication\AuthenticationResult;
use Luma\SecurityComponent\Interface\AuthenticatorInterface;
use Luma\SecurityComponent\Interface\UserInterface;
use Luma\SecurityComponent\Interface\UserProviderInterface;

abstract class Authenticator implements AuthenticatorInterface
{
    protected UserProviderInterface $userProvider;

    /**
     * @param UserProviderInterface $userProvider
     */
    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return AuthenticationResult
     */
    abstract public function authenticate(string $username, string $password): AuthenticationResult;

    /**
     * @param string $username
     * @param string $password
     *
     * @return AuthenticationResult
     */
    abstract public function login(string $username, string $password): AuthenticationResult;

    /**
     * @param UserInterface $user
     *
     * @return AuthenticationResult
     */
    abstract public function register(UserInterface $user): AuthenticationResult;
}