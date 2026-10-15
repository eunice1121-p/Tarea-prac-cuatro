<?php

namespace Tests\Feature;

use Tests\TestCase;

class FanidTest extends TestCase
{
    public function test_fanid_registration_screen_is_rendered(): void
    {
        $this->get('/fanid')
            ->assertOk()
            ->assertSee('Crea tu Cuenta Paddock')
            ->assertSee('name="nickname"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="country"', false)
            ->assertSee('name="favorite_drivers[]"', false)
            ->assertSee('name="terms"', false)
            ->assertSee('name="_token"', false);
    }
}