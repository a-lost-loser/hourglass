<?php

class BackendAuthorizationTest extends TestCase
{
    public function test_it_shows_a_login_page()
    {
        $this->visit('backend')->see('Hourglass');
    }
}
