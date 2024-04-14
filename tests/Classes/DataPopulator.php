<?php

namespace Luma\Tests\Classes;

use Dotenv\Dotenv;
use Luma\AuroraDatabase\DatabaseConnection;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Authentication\Password;

class DataPopulator
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->establish();
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function populate(array $data): void
    {
        foreach ($data as $userData) {
            $this->saveUser($userData['username'], $userData['email'], $userData['password']);
        }
    }

    /**
     * @param string $username
     * @param string $emailAddress
     * @param string $password
     *
     * @return void
     */
    private function saveUser(string $username, string $emailAddress, string $password): void
    {
        User::create([
            'username' => $username,
            'emailAddress' => $emailAddress,
            'password' => Password::hash($password),
        ])->save();
        echo sprintf("\033[0;32mUser Created\033[0m\033[34m %s \033[0m\n", $username);
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    private function establish(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__) . '/data');
        $dotenv->load();

        $databaseConnection = new DatabaseConnection(
            sprintf('mysql:host=%s;port=%s;', $_ENV['DATABASE_HOST'], $_ENV['DATABASE_PORT']),
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD']
        );
        Aurora::setDatabaseConnection($databaseConnection);
    }
}