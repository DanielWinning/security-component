<?php

namespace Luma\SecurityComponent\Interface;

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
     * @return bool
     */
    public function authenticate(string $username, string $password): bool;
}