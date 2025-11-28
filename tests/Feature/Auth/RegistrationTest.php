<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_organizer_registration_sets_pending_status(): void
    {
        $response = $this->post('/register', [
            'name' => 'Organizer User',
            'email' => 'organizer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'organizer',
        ]);

        $this->assertAuthenticated();

        $user = \App\Models\User::where('email', 'organizer@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('organizer', $user->role);
        $this->assertEquals('pending', $user->organizer_status);

        $response->assertRedirect(route('pending'));
    }
}
