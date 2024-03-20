<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\SecurityComponent\Interface\UserInterface;

class AuthenticationResult
{
    private bool $authenticated;
    private ?UserInterface $user;

    public function __construct(bool $authenticated, ?UserInterface $user)
    {
        $this->authenticated = $authenticated;
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }
}