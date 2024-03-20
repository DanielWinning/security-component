<?php

namespace Luma\SecurityComponent\Authentication;

class DatabaseAuthenticator extends Authenticator
{
    /**
     * @param string $username
     * @param string $password
     *
     * @return AuthenticationResult
     */
    public function authenticate(string $username, string $password): AuthenticationResult
    {
        $user = $this->userProvider->loadUserByUsername($username);

        if (!$user) {
            return new AuthenticationResult(false, null);
        }

        return new AuthenticationResult(password_verify($password, $user->getPassword()), $user);
    }
}