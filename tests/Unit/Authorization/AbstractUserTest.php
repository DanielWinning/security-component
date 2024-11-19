<?php

namespace Authorization;

use Luma\SecurityComponent\Entity\Role;
use Luma\Tests\Classes\SecurityComponentUnitTest;
use Luma\Tests\Classes\User;


class AbstractUserTest extends SecurityComponentUnitTest
{
    /**
     * @return void
     */
    public function testHasRole(): void
    {
        $this->assertFalse(
            User::find(1)
                ->with([Role::class])
                ->hasRole(Role::select()->whereIs('handle', 'admin')->get())
        );
        $this->assertTrue(User::find(4)->with([Role::class])->hasRole('admin'));
    }

    /**
     * @return void
     */
    public function testAddRole(): void
    {
        $user = User::find(1)->with([Role::class]);

        $this->assertFalse($user->hasRole('admin'));

        $adminRole = Role::select()->whereIs('handle', 'admin')->get();
        $user->addRole($adminRole);

        $this->assertTrue($user->hasRole('admin'));
    }

    /**
     * @return void
     */
    public function testGetSecurityIdentifier(): void
    {
        $this->assertEquals('username', User::getSecurityIdentifier());
    }
}