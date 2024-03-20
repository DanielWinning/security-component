<?php

namespace Luma\Tests\Classes;

use Dotenv\Dotenv;
use Luma\AuroraDatabase\DatabaseConnection;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Session\DatabaseSessionManager;
use PHPUnit\Framework\TestCase;

class SecurityComponentUnitTest extends TestCase
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

        DatabaseSessionManager::start();
        Aurora::setDatabaseConnection(new DatabaseConnection(
            sprintf('mysql:host=%s;port=%s', $_ENV['DATABASE_HOST'], $_ENV['DATABASE_PORT']),
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD']
        ));
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        DatabaseSessionManager::end();
    }
}