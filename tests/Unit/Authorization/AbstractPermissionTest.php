<?php

namespace Luma\Tests\Unit\Authorization;

use Luma\SecurityComponent\Entity\Permission;
use Luma\Tests\Classes\SecurityComponentUnitTest;

class AbstractPermissionTest extends SecurityComponentUnitTest
{
    public function testAbstractPermission()
    {
        $permission = Permission::create([
            'name' => 'Test Permission',
            'handle' => 'test_permission',
        ]);

        self::assertEquals('Test Permission', $permission->getName());
        self::assertEquals('test_permission', $permission->getHandle());
    }
}