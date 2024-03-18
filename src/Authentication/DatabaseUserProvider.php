<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\AuroraDatabase\DatabaseConnection;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authentication\Interface\UserProviderInterface;

class DatabaseUserProvider implements UserProviderInterface
{
    private DatabaseConnection $databaseConnection;
    private string $databaseTable;
    private string $userClass;

    public function __construct(DatabaseConnection $databaseConnection, string $userClass, string $databaseTable)
    {
        if (!in_array(UserInterface::class, class_implements($userClass))) {
            throw new \InvalidArgumentException(sprintf('%s must implement UserInterface.', $userClass));
        }

        $this->databaseConnection = $databaseConnection;
        $this->databaseTable = $databaseTable;
        $this->userClass = $userClass;
    }

    public function loadUserByUsername(string $username): ?UserInterface
    {
        // TODO: Implement loadUserByUsername() method.
    }
}