<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_screen_is_available_and_contains_expected_fields(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/profile/edit')
            ->assertOk()
            ->assertViewIs('profile.edit')
            ->assertSee('method="POST"', false)
            ->assertSee('name="_method"', false)
            ->assertSee('name="name"', false)
            ->assertSee('name="handle"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="bio"', false)
            ->assertSee('name="city"', false)
            ->assertSee('images/profile-avatar.jpg');
    }

    public function test_profile_edit_screen_requires_authentication(): void
    {
        $this->get('/profile/edit')
            ->assertRedirect('/login');
    }

    public function test_profile_can_be_updated_by_an_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/profile', [
                'name' => 'Santiago Herrera',
                'handle' => 'santi_f1latam',
                'email' => $user->email,
                'bio' => 'Fan de la Fórmula 1.',
                'city' => 'Buenos Aires',
            ])
            ->assertRedirect('/profile/edit')
            ->assertSessionHas('status', 'Perfil actualizado.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Santiago Herrera',
            'handle' => 'santi_f1latam',
            'bio' => 'Fan de la Fórmula 1.',
            'city' => 'Buenos Aires',
        ]);
    }
}
