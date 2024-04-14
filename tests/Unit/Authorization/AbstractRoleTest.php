<?php

namespace Authorization;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\Tests\Classes\Permission;
use Luma\Tests\Classes\Role;
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

        $this->assertInstanceOf(Collection::class, $role->getPermissions());
        $this->assertTrue($role->hasPermission($accessAllAreasPermission));
        $this->assertTrue($role->hasPermission('edit_user'));
        $this->assertFalse($role->hasPermission('unknown'));
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

        $this->assertFalse($role->hasPermission('run_tests'));

        $role->addPermission($runTestsPermission);

        $this->assertTrue($role->hasPermission('run_tests'));
    }
}