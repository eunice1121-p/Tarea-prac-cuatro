<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_is_rendered_with_a_csrf_protected_form(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Bienvenido de vuelta')
            ->assertSee('action="'.route('login').'"', false)
            ->assertSee('method="POST"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="_token"', false);
    }

    public function test_invalid_credentials_return_an_error_to_the_login_form(): void
    {
        $this->from('/login')
            ->post('/login', [
                'email' => 'fan@example.com',
                'password' => 'incorrect-password',
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email')
            ->assertSessionHas('_old_input.email', 'fan@example.com');
    }

    public function test_valid_credentials_authenticate_the_user_and_honor_remember_me(): void
    {
        $user = User::factory()->create([
            'password' => 'correct-password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'correct-password',
            'remember' => '1',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

        $this->assertNotNull($user->fresh()->getRememberToken());
    }
}