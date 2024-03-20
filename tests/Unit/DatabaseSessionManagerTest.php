<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Session\DatabaseSessionManager;
use Luma\Tests\Classes\SecurityComponentUnitTest;
use Luma\Tests\Classes\User;

class DatabaseSessionManagerTest extends SecurityComponentUnitTest
{
    /**
     * @return void
     */
    public function testItStartsAndEndsSession(): void
    {
        $this->assertIsString(session_id());
        $this->assertNotEmpty(session_id());
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     *
     * @dataProvider sessionItemProvider
     */
    public function testItGetsAndSetsItems(string $key, mixed $value): void
    {
        DatabaseSessionManager::setSessionItem($key, $value);

        $this->assertEquals(DatabaseSessionManager::getSessionItem($key), $value);
    }

    public function testItGetsAndSetsUser(): void
    {
        $user = User::find(1);

        DatabaseSessionManager::setSessionItem('user', $user);

        $this->assertEquals(DatabaseSessionManager::getSessionItem('user'), $user);
    }

    /**
     * @return array
     */
    public static function sessionItemProvider(): array
    {
        return [
            [
                'key' => 'userId',
                'value' => 123,
            ],
            [
                'key' => 'username',
                'value' => 'Danny',
            ],
        ];
    }
}