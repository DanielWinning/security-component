<?php

namespace Luma\Tests\Classes;

use Dotenv\Dotenv;
use Luma\AuroraDatabase\DatabaseConnection;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;
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
        foreach ($data['permissions'] as $permissionData) {
            Permission::create($permissionData)->save();

            $this->printCreationText('Permission', $permissionData['name']);
        }
        echo "\r\n";

        foreach ($data['roles'] as $roleData) {
            $permissions = new Collection(array_map(function (string $permission) {
                return Permission::select()->whereIs('handle', $permission)->get();
            }, $roleData['permissions']));

            $roleData['permissions'] = $permissions;

            Role::create($roleData)->save();

            $this->printCreationText('Role', $roleData['name']);
        }

        echo "\r\n";

        foreach ($data['users'] as $userData) {
            $this->saveUser($userData['username'], $userData['email'], $userData['password'], $userData['roles']);
        }
    }

    /**
     * @param string $username
     * @param string $emailAddress
     * @param string $password
     * @param array $roles
     *
     * @return void
     */
    private function saveUser(string $username, string $emailAddress, string $password, array $roles): void
    {
        $userRoles = [];

        foreach ($roles as $userRole) {
            $userRoles[] = Role::select()->whereIs('handle', $userRole)->get();
        }

        User::create([
            'username' => $username,
            'emailAddress' => $emailAddress,
            'password' => Password::hash($password),
            'roles' => new Collection($userRoles),
        ])->save();

        $this->printCreationText('User', $username);
    }

    /**
     * @param string $entityType
     * @param string $entityName
     *
     * @return void
     */
    private function printCreationText(string $entityType, string $entityName): void
    {
        echo sprintf("\033[0;32m%s Created\033[0m\033[34m %s \033[0m\n", $entityType, $entityName);
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