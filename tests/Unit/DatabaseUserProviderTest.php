<?php

namespace Luma\Tests\Unit;

use Dotenv\Dotenv;
use Luma\AuroraDatabase\DatabaseConnection;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Authentication\DatabaseUserProvider;
use Luma\SecurityComponent\Exception\InvalidUserModelException;
use Luma\SecurityComponent\Interface\UserInterface;
use Luma\Tests\Classes\InvalidUser;
use Luma\Tests\Classes\InvalidUserWithoutAurora;
use Luma\Tests\Classes\InvalidUserWithoutUI;
use Luma\Tests\Classes\User;
use PHPUnit\Framework\TestCase;

class DatabaseUserProviderTest extends TestCase
{
    /**
     * @return void
     *
     * @throws \Exception
     */
    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(sprintf('%s/data', dirname(__DIR__)));
        $dotenv->load();

        Aurora::setDatabaseConnection(new DatabaseConnection(
            sprintf('mysql:host=%s;port=%s', $_ENV['DATABASE_HOST'], $_ENV['DATABASE_PORT']),
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD']
        ));
    }

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
     * @throws \ReflectionException
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