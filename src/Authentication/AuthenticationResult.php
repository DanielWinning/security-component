<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\SecurityComponent\Interface\UserInterface;

class AuthenticationResult
{
    private bool $authenticated;
    private ?UserInterface $user;

    /**
     * @param bool $authenticated
     * @param UserInterface|null $user
     */
    public function __construct(bool $authenticated, ?UserInterface $user = null)
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