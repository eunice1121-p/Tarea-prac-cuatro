<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
            ->assertSee('name="avatar"', false);
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
                'country' => 'argentina',
                'favorite_drivers' => ['Max Verstappen', 'Franco Colapinto'],
            ])
            ->assertRedirect('/profile/edit')
            ->assertSessionHas('status', 'Perfil actualizado.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Santiago Herrera',
            'handle' => 'santi_f1latam',
            'bio' => 'Fan de la Fórmula 1.',
            'city' => 'Buenos Aires',
            'country' => 'argentina',
            'favorite_drivers' => json_encode(['Max Verstappen', 'Franco Colapinto']),
        ]);
        $this->assertSame(['Max Verstappen', 'Franco Colapinto'], $user->fresh()->favorite_drivers);
    }

    public function test_profile_avatar_can_be_uploaded_and_stored(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put('/profile', [
                'name' => $user->name,
                'email' => $user->email,
                'country' => 'mexico',
                'favorite_drivers' => ['Max Verstappen'],
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            ])
            ->assertRedirect('/profile/edit')
            ->assertSessionHasNoErrors();

        $user->refresh();
        $this->assertNotNull($user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
    }

    public function test_logout_ends_the_authenticated_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/login');
        $this->assertGuest();
    }
}
