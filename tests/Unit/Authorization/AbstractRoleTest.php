<?php

namespace Luma\Tests\Unit\Authorization;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Entity\Permission;
use Luma\SecurityComponent\Entity\Role;

use Luma\Tests\Classes\SecurityComponentUnitTest;

class AbstractRoleTest extends SecurityComponentUnitTest
{
    /**
     * @return void
     */
    public function testHasPermission(): void
    {
        $role = Role::select()
            ->whereIs('handle', 'admin')
            ->get()
            ->with([Permission::class]);
        $accessAllAreasPermission = Permission::select()
            ->whereIs('handle', 'access_all_areas')
            ->get();

        self::assertEquals('Administrator', $role->getName());
        self::assertEquals('admin', $role->getHandle());
        self::assertInstanceOf(Collection::class, $role->getPermissions());
        self::assertTrue($role->hasPermission($accessAllAreasPermission));
        self::assertTrue($role->hasPermission('edit_user'));
        self::assertFalse($role->hasPermission('unknown'));
    }

    /**
     * @return void
     */
    public function testAddPermission(): void
    {
        $role = Role::select()
            ->whereIs('handle', 'admin')
            ->get()
            ->with([Permission::class]);
        $runTestsPermission = Permission::create([
            'name' => 'Run Tests',
            'handle' => 'run_tests',
        ]);

        self::assertFalse($role->hasPermission('run_tests'));

        $role->addPermission($runTestsPermission);

        self::assertTrue($role->hasPermission('run_tests'));
    }
}