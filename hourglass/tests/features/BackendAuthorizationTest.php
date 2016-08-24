<?php

use Hourglass\Models\User;

class BackendAuthorizationTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    public function test_it_redirects_to_a_login_page()
    {
        $this->visit('backend')->seePageIs('backend/login');
    }

    public function test_it_does_not_redirect_to_the_login_page_when_authenticated()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->visit('backend')
            ->seePageIs('backend');
    }
}
