<?php

namespace Luma\Tests\Unit;

use Dotenv\Dotenv;
use Luma\AuroraDatabase\DatabaseConnection;
use Luma\SecurityComponent\Authentication\DatabaseUserProvider;
use Luma\Tests\Classes\InvalidUser;
use Luma\Tests\Classes\User;
use PHPUnit\Framework\TestCase;

class DatabaseUserProviderTest extends TestCase
{
    private DatabaseConnection $databaseConnection;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(sprintf('%s/data', dirname(__DIR__)));
        $dotenv->load();

        $this->databaseConnection = new DatabaseConnection(
            sprintf('mysql:host=%s;port=%s', $_ENV['DATABASE_HOST'], $_ENV['DATABASE_PORT']),
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD']
        );
    }

    /**
     * @return void
     */
    public function testItCreatesAnInstanceOfDatabaseUserProvider(): void
    {
        $databaseUserProvider = new DatabaseUserProvider($this->databaseConnection, User::class, 'User.tblUser');

        $this->assertInstanceOf(DatabaseUserProvider::class, $databaseUserProvider);

        $this->expectException(\InvalidArgumentException::class);
        (new DatabaseUserProvider($this->databaseConnection, InvalidUser::class, 'User.tblUser'));
    }
}