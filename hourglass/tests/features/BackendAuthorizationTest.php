<?php

class BackendAuthorizationTest extends TestCase
{
    public function test_it_redirects_to_a_login_page()
    {
        $this->visit('backend')->seePageIs('backend/login');
    }
}
