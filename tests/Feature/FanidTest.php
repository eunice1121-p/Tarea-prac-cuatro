<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FanidTest extends TestCase
{
    use RefreshDatabase;

    public function test_fanid_registration_screen_is_rendered(): void
    {
        $this->get('/fanid')
            ->assertOk()
            ->assertSee('Crea tu Cuenta Paddock')
            ->assertSee('name="nickname"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="password_confirmation"', false)
            ->assertSee('name="country"', false)
            ->assertSee('name="favorite_drivers[]"', false)
            ->assertSee('name="terms"', false)
            ->assertSee('name="_token"', false);
    }

    public function test_valid_fanid_registration_creates_and_authenticates_user(): void
    {
        $response = $this->post('/fanid', [
            'nickname' => 'Santiago Herrera',
            'email' => 'santiago@example.com',
            'password' => 'correct-password',
            'password_confirmation' => 'correct-password',
            'country' => 'argentina',
            'favorite_drivers' => ['Max Verstappen', 'Franco Colapinto'],
            'terms' => '1',
        ]);

        $user = User::where('email', 'santiago@example.com')->firstOrFail();

        $response->assertRedirect('/profile/edit')
            ->assertSessionHas('status', 'Cuenta Paddock creada correctamente.')
            ->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);

        $this->assertSame('Santiago Herrera', $user->name);
        $this->assertSame('argentina', $user->country);
        $this->assertSame(['Max Verstappen', 'Franco Colapinto'], $user->favorite_drivers);
        $this->assertTrue(password_verify('correct-password', $user->password));
    }

    public function test_fanid_registration_rejects_invalid_input_and_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->from('/fanid')->post('/fanid', [
            'nickname' => '',
            'email' => 'taken@example.com',
            'password' => 'short',
            'password_confirmation' => 'different',
            'country' => 'unknown',
            'favorite_drivers' => ['Unknown Driver'],
        ])
            ->assertRedirect('/fanid')
            ->assertSessionHasErrors([
                'nickname',
                'email',
                'password',
                'country',
                'favorite_drivers.0',
                'terms',
            ]);
        $this->assertGuest();
    }
}