<?php

namespace Luma\SecurityComponent\Authentication\Authenticators;

use Luma\SecurityComponent\Authentication\AuthenticationResult;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Session\DatabaseSessionManager;

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

    /**
     * @param string $username
     * @param string $password
     *
     * @return AuthenticationResult
     */
    public function login(string $username, string $password): AuthenticationResult
    {
        $authenticationResult = $this->authenticate($username, $password);

        if ($authenticationResult->isAuthenticated()) {
            DatabaseSessionManager::setSessionItem('user', $authenticationResult->getUser());
            DatabaseSessionManager::regenerate();
        }

        return $authenticationResult;
    }

    /**
     * @param string|null $redirectPath
     *
     * @return void
     */
    #[\Override]
    public function logout(?string $redirectPath = null): void
    {
        DatabaseSessionManager::end();
        DatabaseSessionManager::start();

        if ($redirectPath) {
            header('Location: ' . $redirectPath);
        }
    }

    /**
     * @param UserInterface $user
     *
     * @return AuthenticationResult
     */
    public function register(UserInterface $user): AuthenticationResult
    {
        $existingUser = $this->userProvider->loadUserByUsername($user->getUsername());

        if ($existingUser) {
            return new AuthenticationResult(false, null);
        }

        DatabaseSessionManager::setSessionItem('user', $user->save());

        return new AuthenticationResult(true, $user);
    }
}