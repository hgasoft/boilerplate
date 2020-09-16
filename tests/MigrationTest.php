<?php

namespace Sebastienheyd\Boilerplate\Tests;

class MigrationTest extends TestCase
{
    public function testPermissions()
    {
        $res = \DB::table('permissions')->pluck('name')->toArray();
        $this->assertEquals(['backend_access', 'logs', 'roles_crud', 'users_crud'], $res);
    }

    public function testUsersTable()
    {
        $columns = \Schema::getColumnListing('users');
        $this->assertTrue(! in_array('name', $columns));
        $this->assertEmpty(array_diff(['active', 'first_name', 'last_name', 'last_login'], $columns));
    }
}
