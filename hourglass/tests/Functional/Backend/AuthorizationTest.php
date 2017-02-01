<?php namespace Tests\Functional\Backend;

use Laravel\Dusk\Browser;
use Hourglass\Models\User;
use Hourglass\Foundation\Testing\BrowserTestCase;

class AuthorizationTest extends BrowserTestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Hourglass\Foundation\Testing\DatabaseSeeds;

    public function test_it_redirects_to_a_login_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('backend')->assertPathIs('/backend/login');
        });
    }

    public function test_it_does_not_redirect_to_the_login_page_when_authenticated()
    {
        $user = factory(User::class)->create();

        $user->setIndividualPermission('Hourglass.Backend::access.backend', true);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('backend')
                ->assertPathIs('/backend');
        });
    }

    public function test_it_displays_an_error_if_the_user_is_not_allowed_to_enter_the_backend()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)
            ->get('backend');

        $response->assertStatus(500);
    }

    public function test_it_allows_you_to_log_in()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@gethourglass.io',
            'password' => bcrypt('abc'),
        ]);

        $user->setIndividualPermission('Hourglass.Backend::access.backend', true);

        $this->browse(function (Browser $browser) {
            $browser->visit('backend/login')
                ->type('email', 'admin@gethourglass.io')
                ->type('password', 'abc')
                ->press('Log In')
                ->assertPathIs('/backend');
        });
    }

    public function test_it_redirects_back_to_the_login_form_when_the_login_credentials_are_incorrect()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('backend/login')
                ->type('email', 'admin@gethourglass.io')
                ->type('password', 'doesnotexist')
                ->press('Log In')
                ->assertPathIs('/backend/login');
        });
    }
}
