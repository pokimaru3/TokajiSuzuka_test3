<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 管理者はログインできる()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.index'));
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function 管理者以外はログインできない()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $manager = User::factory()->create([
            'email' => 'manager@example.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        $this->post(route('admin.login'), [
            'email' => 'user@example.com',
            'password' => 'password123',
        ])->assertSessionHasErrors();

        $this->assertGuest();

        $this->post(route('admin.login'), [
            'email' => 'manager@example.com',
            'password' => 'password123',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }
}
