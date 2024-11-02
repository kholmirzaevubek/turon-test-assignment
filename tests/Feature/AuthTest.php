<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        Role::updateOrCreate(['id' => 1], ['name' => 'admin']);

        // Seed a user in the database for testing
        $this->user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('validpassword'),
            'role_id' => 1, // Add 'admin' for admin user tests
        ]);
    }

    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'validuser',
            'password' => bcrypt('validpassword'),
            'role_id' => 1, // Assuming role_id 1 exists
        ]);

        $response = $this->post(route('auth.sign-in'), [
            'username' => 'validuser',
            'password' => 'validpassword',
        ]);

        $response->assertRedirect(route('home')); // Adjust this if your redirection is different
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_invalid_username()
    {
        $response = $this->post(route('auth.sign-in'), [
            'username' => 'invaliduser',
            'password' => 'validpassword',
        ]);

        $response->assertRedirect(route('auth.show-sign-in'));
        $response->assertSessionHasErrors(['username']);
    }

    public function test_login_with_invalid_password()
    {
        $response = $this->post(route('auth.sign-in'), [
            'username' => 'testuser',
            'password' => 'invalidpassword',
        ]);

        $response->assertRedirect(route('auth.show-sign-in'));
        $response->assertSessionHasErrors(['password']);
    }

    public function test_login_as_admin()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'username' => 'adminuser',
            'password' => Hash::make('adminpassword'),
            'role_id' => 1,
        ]);

        $response = $this->post(route('auth.show-sign-in'), [
            'username' => 'adminuser',
            'password' => 'adminpassword',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($admin);
    }
}
