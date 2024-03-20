<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Authentication\DatabaseAuthenticator;
use Luma\SecurityComponent\Authentication\DatabaseUserProvider;
use Luma\SecurityComponent\Authentication\Password;
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
        $this->assertTrue(
            (new DatabaseAuthenticator(new DatabaseUserProvider(User::class)))->authenticate($username, $password)
        );
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return void
     *
     * @dataProvider invalidCredentialsProvider
     */
    public function testItDoesNotAuthenticate(string $username, string $password): void
    {
        $this->assertFalse(
            (new DatabaseAuthenticator(new DatabaseUserProvider(User::class)))->authenticate($username, $password)
        );
    }

    /**
     * @param string $password
     *
     * @return void
     *
     * @dataProvider passwordProvider
     */
    public function testPasswordHash(string $password)
    {
        $this->assertNotEquals($password, Password::hash($password));
    }

    /**
     * @return array[]
     */
    public static function passwordProvider(): array
    {
        return [
            [
                'test',
            ],
            [
                'P4$$w0Rd123!',
            ],
        ];
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
            ],
            'User does not exist' => [
                'username' => 'Test User',
                'password' => 'password',
            ],
        ];
    }
}