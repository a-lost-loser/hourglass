<?php namespace Tests\Unit\Backend\Classes;

use Hourglass\Models\Permission;
use Hourglass\Foundation\Testing\BrowserTestCase;

class PermissionsTest extends BrowserTestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Hourglass\Foundation\Testing\DatabaseSeeds;

    public function test_it_finds_permissions_by_their_name()
    {
        $permission = Permission::withName('Hourglass.Backend::access.backend');

        $this->assertEquals('Hourglass.Backend::access.backend', $permission->name);
    }

    public function test_it_returns_null_when_the_name_does_not_exist()
    {
        $permission = Permission::withName('Hourglass.Backend::this.is.a.very.unlikely.test');

        $this->assertNull($permission);
    }
}
