<?php namespace Tests\Unit\Backend\Classes;

use Hourglass\Foundation\Testing\TestCase;
use Hourglass\Models\User;

class UserTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Hourglass\Foundation\Testing\DatabaseSeeds;

    public function test_it_can_be_given_individual_permissions()
    {
        $user = factory(User::class)->create();
        $user->setIndividualPermission('Hourglass.Backend::access.backend', true);

        $this->assertTrue($user->can('Hourglass.Backend::access.backend'));
        $this->assertFalse($user->can('Hourglass.Backend::access.something.else'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_it_throws_an_exception_when_given_a_permission_that_does_not_exist()
    {
        $user = factory(User::class)->make();
        $user->setIndividualPermission('Hourglass.Backend::this.is.a.very.unlikely.test', true);
    }
}
