<?php

// Path: tests\Feature\Users\UsersManagementTest.php
// Write the tests  for the following features:
//    - A user can be created
//    - A user can be updated
//    - A user can be deleted
//    - The users must have the "admin" role to be able to create, update or delete users
//    - The index page can be rendered
//    - The show page can be rendered



namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_must_have_admin_role_to_create_update_or_delete_users(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/users/create', [
                'name' => 'Test User',
                'email' => 'test@test.tld',
                'password' => 'password',
                'role' => 'user',
                'password_confirmation' => 'password',
            ]);

        $response->assertSessionHas('error');

        $response = $this
            ->actingAs($user)
            ->patch('/users/' . $user->id, [
                'name' => 'Test User',
                'email' => 'test@test.tld',
                'role' => 'user',
            ]);

        $response->assertSessionHas('error');

        $response = $this
            ->actingAs($user)
            ->delete('/users/' . $user->id);

        $response->assertSessionHas('error');
    }

    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/users', [
                'name' => 'Test User',
                'email' => 'test@test.tld',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertSessionHasNoErrors();
    }

    public function test_user_can_be_updated(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch('/users/' . $user->id, [
                'name' => 'Test User',
                'email' => 'test@test.tld',
            ]);

        $response->assertSessionHasNoErrors();

    }

    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('/users/' . $user->id);

        $response->assertSessionHasNoErrors();
    }

    public function test_index_page_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/users');

        $response->assertOk();
    }

    public function test_show_page_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/users/' . $user->id);

        $response->assertOk();
    }



}
