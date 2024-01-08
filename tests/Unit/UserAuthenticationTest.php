<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthenticationTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function it_authenticates_user_with_valid_credentials()
    {
        // Arrange
        $user = \Database\Factories\UserFactory::new()->create([
            'email' => 'test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);
        

        // Act
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Assert
        $response->assertRedirect(route('dashboard')); // Assuming successful login redirects to the dashboard
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_rejects_user_with_invalid_credentials()
    {
        // Act
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        // Assert
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
