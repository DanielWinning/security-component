<?php

namespace Luma\Tests\Unit;

use Luma\SecurityComponent\Authentication\Password;
use Luma\Tests\Classes\SecurityComponentUnitTest;

class PasswordTest extends SecurityComponentUnitTest
{
    /**
     * @param int $length
     * +
     *
     * @return void
     *
     * @dataProvider passwordLengthProvider
     */
    public function testItGeneratesRandomPassword(int $length)
    {
        $password = Password::generateRandom($length);

        $this->assertIsString($password);
        $this->assertEquals($length, strlen($password));
    }

    /**
     * @param string $password
     *
     * @return void
     *
     * @dataProvider passwordProvider
     */
    public function testItsHashesPassword(string $password)
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
            [
                Password::generateRandom(255),
            ],
        ];
    }

    /**
     * @return int[][]
     */
    public static function passwordLengthProvider(): array
    {
        return [
            [
                10,
            ],
            [
                8,
            ],
            [
                42,
            ]
        ];
    }
}