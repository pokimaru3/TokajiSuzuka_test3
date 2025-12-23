<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ManagerCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 管理者は店舗代表者を作成できる()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.store'), [
            'name' => 'manager',
            'email' => 'manager@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'manager@example.com',
            'role' => 'manager',
        ]);
    }

    /** @test */
    public function メールアドレスが重複している場合は作成できない()
    {
        User::factory()->create([
            'email' => 'manager@example.com',
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.store'), [
            'name' => 'manager',
            'email' => 'manager@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 2);
    }
}
