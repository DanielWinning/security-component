<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Authentication\DatabaseAuthenticator;
use Luma\SecurityComponent\Authentication\DatabaseUserProvider;
use Luma\SecurityComponent\Authentication\Password;
use Luma\SecurityComponent\Interface\UserInterface;
use Luma\Tests\Classes\SecurityComponentUnitTest;
use Luma\Tests\Classes\User;

class AuthenticatorTest extends SecurityComponentUnitTest
{
    /**
     * @return void
     */
    public function testItCreatesAnInstanceOfAuthenticator(): void
    {
        $databaseAuthenticator = new DatabaseAuthenticator(new DatabaseUserProvider(User::class));

        $this->assertInstanceOf(DatabaseAuthenticator::class, $databaseAuthenticator);
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     *
     * @dataProvider validCredentialsProvider
     */
    public function testItAuthenticates(string $username, string $password): void
    {
        $authenticationResult = (new DatabaseAuthenticator(new DatabaseUserProvider(User::class)))
            ->authenticate($username, $password);

        $this->assertTrue($authenticationResult->isAuthenticated());
        $this->assertInstanceOf(UserInterface::class, $authenticationResult->getUser());
    }

    /**
     * @param string $username
     * @param string $password
     * @param bool $userExists
     *
     * @return void
     *
     * @dataProvider invalidCredentialsProvider
     */
    public function testItDoesNotAuthenticate(string $username, string $password, bool $userExists): void
    {
        $authenticationResult = (new DatabaseAuthenticator(new DatabaseUserProvider(User::class)))
            ->authenticate($username, $password);

        $this->assertFalse($authenticationResult->isAuthenticated());

        if ($userExists) {
            $this->assertInstanceOf(UserInterface::class, $authenticationResult->getUser());
        } else {
            $this->assertNull($authenticationResult->getUser());
        }
    }

    /**
     * @return array[]
     */
    public static function validCredentialsProvider(): array
    {
        return [
            [
                'username' => 'Danny',
                'password' => 'P4$$w0rd123!',
            ],
            [
                'username' => 'Abbie',
                'password' => 'abbie',
            ],
            [
                'username' => 'Charlie',
                'password' => 'p4$$word123',
            ],
        ];
    }

    /**
     * @return array[]
     */
    public static function invalidCredentialsProvider(): array
    {
        return [
            'User exists, incorrect password' => [
                'username' => 'Danny',
                'password' => 'password',
                'userExists' => true,
            ],
            'User does not exist' => [
                'username' => 'Test User',
                'password' => 'password',
                'userExists' => false,
            ],
        ];
    }
}