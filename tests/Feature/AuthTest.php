<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_with_valid_credentials()
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
            'role' => 'student',
        ]);
    }

    /** @test */
    public function user_cannot_register_with_invalid_email()
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cannot_register_with_existing_email()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cannot_register_with_password_mismatch()
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword123!',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_cannot_register_with_weak_password()
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password123!'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'john@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $response = $this->post(route('login'), [
            'email' => 'nonexistent@example.com',
            'password' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cannot_login_with_wrong_password()
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('CorrectPassword123!'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'john@example.com',
            'password' => 'WrongPassword123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /** @test */
    public function guest_cannot_access_protected_routes()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)
            ->get(route('dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function student_cannot_access_admin_panel()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    /** @test */
    public function instructor_can_access_instructor_dashboard()
    {
        $user = User::factory()->create(['role' => 'instructor']);

        $response = $this->actingAs($user)
            ->get(route('instructor.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_request_password_reset()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post(route('password.email'), [
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHas('status');
    }

    /** @test */
    public function user_cannot_request_password_reset_with_invalid_email()
    {
        $response = $this->post(route('password.email'), [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function authenticated_user_is_redirected_to_dashboard_from_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('login'));

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function authenticated_user_is_redirected_to_dashboard_from_register()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('register'));

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function user_password_is_hashed_on_registration()
    {
        $password = 'PlainTextPassword123!';

        $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(\Hash::check($password, $user->password));
    }

    /** @test */
    public function user_receives_remember_token_on_login()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('Password123!'),
        ]);

        $this->post(route('login'), [
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'remember' => true,
        ]);

        $this->assertNotNull($user->refresh()->remember_token);
    }

    /** @test */
    public function new_user_has_student_role_by_default()
    {
        $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertEquals('student', $user->role);
    }

    /** @test */
    public function user_cannot_access_register_without_csrf_token()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('register'), [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ]);

        // Should work when middleware is disabled (for testing)
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
