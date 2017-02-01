<?php namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Hourglass\Foundation\Testing\BrowserTestCase;

class ExampleTest extends BrowserTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
