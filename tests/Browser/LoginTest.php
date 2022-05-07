<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function testGoToLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login')
                    ->assertPresent('input[name="email"]')
                    ->assertPresent('input[name="password"]')
                    ->assertPresent('#btnLogin')
                    ->assertPresent('#register');
        });
    }

    public function testRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->click('#register');
            $browser->assertPathIs('/register');
        });
    }

    public function testRequireEmailAndPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->click('#btnLogin');
            $browser->assertPathIs('/login')
                    ->assertSee('The email field is required.')
                    ->assertSee('The password field is required.');
        });
    }

    public function testLoginFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'customerfail@gmail.com')
                    ->type('password', 'customerfail')
                    ->click('#btnLogin')
                    ->assertSee('Login unsuccessful!')
                    ->assertPathIs('/login');
        });
    }

    public function testLoginSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'customer@gmail.com')
                    ->type('password', 'customer')
                    ->click('#btnLogin')
                    ->assertPathIs('/home');
        });
    }
}
