<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

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
        //copy test image to new location
        copy(resource_path('img/test.jpg'), resource_path('img/test2.jpg'));
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'phone' => '1234567890',
            'address' => '123 Test Street',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_picture' => new \Illuminate\Http\UploadedFile(
                resource_path('img/test2.jpg'), // Correct file path as a string
                'profile_picture.jpg',
                'image/jpeg',
                null,
                true
            ),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));

    }
}
