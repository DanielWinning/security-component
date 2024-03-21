<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Authentication\Authenticators\DatabaseAuthenticator;
use Luma\SecurityComponent\Authentication\Password;
use Luma\SecurityComponent\Authentication\Providers\DatabaseUserProvider;
use Luma\SecurityComponent\Interface\UserInterface;
use Luma\SecurityComponent\Session\DatabaseSessionManager;
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
     * @return void
     */
    public function testItLogsIn(): void
    {
        $this->assertNull(DatabaseSessionManager::getSessionItem('user'));

        $authenticator = new DatabaseAuthenticator(new DatabaseUserProvider(User::class));

        $user = User::find(4);

        $this->assertTrue($authenticator->login($user->getUsername(), 'P4$$w0rd123!')->isAuthenticated());

        $loggedInUser = DatabaseSessionManager::getSessionItem('user');

        $this->assertInstanceOf(UserInterface::class, $loggedInUser);
        $this->assertEquals('Danny', $loggedInUser->getUsername());
    }

    /**
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testItRegistersNewUser(): void
    {
        // Existing username
        $user = User::create([
            'username' => 'Danny',
            'password' => Password::hash('testing'),
            'emailAddress' => 'danny@test.com',
        ]);

        $authenticator = new DatabaseAuthenticator(new DatabaseUserProvider(User::class));

        $this->assertFalse($authenticator->register($user)->isAuthenticated());

        $user = User::create([
            'username' => 'New User',
            'password' => Password::generateRandom(10),
            'emailAddress' => 'new_user@test.com',
        ]);

        $this->assertTrue($authenticator->register($user)->isAuthenticated());

        $createdUser = User::findBy('username', 'New User');

        $this->assertNotNull($createdUser);
        $this->assertEquals('new_user@test.com', $createdUser->getEmailAddress());
        $this->assertArrayHasKey('user', $_SESSION);
        $this->assertEquals($createdUser->getEmailAddress(), DatabaseSessionManager::getSessionItem('user')->getEmailAddress());

        $createdUser->delete();
    }

    /**
     * @return array[]
     */
    public function newUserDataProvider(): array
    {
        return [
            [
                'username' => 'Daniel',
                'emailAddress' => 'daniel@test.com',
                'password' => Password::generateRandom(8),
            ],
            [
                'username' => 'Grace',
                'emailAddress' => 'grace@test.com',
                'password' => Password::generateRandom(16),
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