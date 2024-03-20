<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Authentication\DatabaseUserProvider;
use Luma\SecurityComponent\Exception\InvalidUserModelException;
use Luma\SecurityComponent\Interface\UserInterface;
use Luma\Tests\Classes\InvalidUser;
use Luma\Tests\Classes\InvalidUserWithoutAurora;
use Luma\Tests\Classes\InvalidUserWithoutUI;
use Luma\Tests\Classes\SecurityComponentUnitTest;
use Luma\Tests\Classes\User;
use Luma\Tests\Classes\UserMissingAttributes;

class DatabaseUserProviderTest extends SecurityComponentUnitTest
{
    /**
     * @return void
     */
    public function testItCreatesAnInstanceOfDatabaseUserProviderWithValidUserClass(): void
    {
        $this->assertInstanceOf(DatabaseUserProvider::class, new DatabaseUserProvider(User::class));
    }

    /**
     * @param string $className
     *
     * @return void
     *
     * @throws \Exception
     *
     * @dataProvider invalidUserClassProvider
     */
    public function testItThrowsAnInvalidUserModelException(string $className): void
    {
        $this->expectException(InvalidUserModelException::class);
        new DatabaseUserProvider($className);
    }

    /**
     * @return void
     *
     * @throws \ReflectionException|InvalidUserModelException
     */
    public function testLoadByUsername(): void
    {
        $databaseUserProvider = new DatabaseUserProvider(User::class);

        /**
         * @var User $user
         */
        $user = $databaseUserProvider->loadUserByUsername('Danny');

        $this->assertInstanceOf(UserInterface::class, $user);
        $this->assertEquals('danny@test.com', $user->getEmailAddress());

        $notExistingUser = $databaseUserProvider->loadUserByUsername('Gary');

        $this->assertNull($notExistingUser);

        $databaseUserProvider = new DatabaseUserProvider(UserMissingAttributes::class);

        $this->expectException(InvalidUserModelException::class);
        $user = $databaseUserProvider->loadUserByUsername('Danny');
    }

    /**
     * @return void
     */
    public function testLoadById(): void
    {
        $databaseUserProvider = new DatabaseUserProvider(User::class);
        $user = $databaseUserProvider->loadById(4);

        $this->assertEquals('Danny', $user->getUsername());
        $this->assertEquals(4, $user->getId());
    }

    /**
     * @return array[]
     */
    public static function invalidUserClassProvider(): array
    {
        return [
            [
                'className' => InvalidUser::class,
            ],
            [
                'className' => InvalidUserWithoutUI::class,
            ],
            [
                'className' => InvalidUserWithoutAurora::class,
            ],
        ];
    }
}