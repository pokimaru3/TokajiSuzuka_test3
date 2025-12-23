<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 店舗代表者はログインできる()
    {
        $manager = User::factory()->create([
            'email' => 'manager@example.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        $response = $this->post(route('manager.login'), [
            'email' => 'manager@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('manager.shop.index'));
        $this->assertAuthenticatedAs($manager);
    }

    /** @test */
    public function 店舗代表者以外はログインできない()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->post(route('manager.login'), [
            'email' => 'user@example.com',
            'password' => 'password123',
        ])->assertSessionHasErrors();

        $this->assertGuest();

        $this->post(route('manager.login'), [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }
}
