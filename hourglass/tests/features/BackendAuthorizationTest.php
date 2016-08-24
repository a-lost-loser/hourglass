<?php

class BackendAuthorizationTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;

    public function test_it_redirects_to_a_login_page()
    {
        $this->visit('backend')->seePageIs('backend/login');
    }
}
