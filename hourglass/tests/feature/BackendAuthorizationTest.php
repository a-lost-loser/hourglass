<?php

use Hourglass\Models\User;

class BackendAuthorizationTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Hourglass\Foundation\Testing\DatabaseSeeds;

    public function test_it_redirects_to_a_login_page()
    {
        $this->visit('backend')->seePageIs('backend/login');
    }

    public function test_it_does_not_redirect_to_the_login_page_when_authenticated()
    {
        $user = factory(User::class)->create();
        $user->setIndividualPermission('Hourglass.Backend::access.backend', true);

        $this->actingAs($user)
            ->visit('backend')
            ->seePageIs('backend');
    }

    public function test_it_displays_an_error_if_the_user_is_not_allowed_to_enter_the_backend()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->call('GET', $this->prepareUrlForRequest('backend'));

        $this->seeStatusCode(500);
    }
}
