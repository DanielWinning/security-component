<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Session\SessionManager;
use Luma\Tests\Classes\SecurityComponentUnitTest;

class SessionManagerTest extends SecurityComponentUnitTest
{
    /**
     * @return void
     */
    public function testItStartsAndEndsSession(): void
    {
        SessionManager::start();

        $this->assertIsString(session_id());
        $this->assertNotEmpty(session_id());

        SessionManager::end();

        $this->assertEmpty(session_id());
    }

    /**
     * @param string $key
     * @param string|int $value
     *
     * @return void
     *
     * @dataProvider sessionItemProvider
     */
    public function testItGetsAndSetsItems(string $key, string|int $value): void
    {
        SessionManager::start();
        SessionManager::setSessionItem($key, $value);

        $this->assertEquals(SessionManager::getSessionItem($key), $value);

        SessionManager::end();
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