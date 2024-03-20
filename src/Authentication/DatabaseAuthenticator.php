<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\SecurityComponent\Interface\UserProviderInterface;

class DatabaseAuthenticator extends Authenticator
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function authenticate(string $username, string $password): bool
    {
        $user = $this->userProvider->loadUserByUsername($username);

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->getPassword());
    }
}