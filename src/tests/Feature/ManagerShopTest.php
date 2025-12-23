<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;

class ManagerShopTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 店舗代表者は店舗を作成できる()
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $this->actingAs($manager);

        $response = $this->post(route('manager.store'), [
            'name' => 'Test Shop',
            'area' => '東京都',
            'genre' => '寿司',
            'description' => 'テスト説明',
            'max_capacity' => 10,
        ]);

        $response->assertRedirect(route('manager.shop.index'));

        $this->assertDatabaseHas('shops', [
            'name' => 'Test Shop',
            'manager_id' => $manager->id,
        ]);
    }

    /** @test */
    public function 店舗代表者は自分の店舗を編集できる()
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $shop = Shop::factory()->create([
            'manager_id' => $manager->id,
            'name' => 'Old Shop Name',
        ]);

        $this->actingAs($manager);

        $response = $this->put(route('manager.shop.update', $shop->id), [
            'name' => 'New Shop Name',
            'area' => $shop->area,
            'genre' => $shop->genre,
            'description' => $shop->description,
            'max_capacity' => $shop->max_capacity,
        ]);

        $response->assertRedirect(route('manager.shop.index'));

        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'name' => 'New Shop Name',
        ]);
    }

    /** @test */
    public function 他人の店舗は編集できない()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $otherManager = User::factory()->create(['role' => 'manager']);

        $shop = Shop::factory()->create([
            'manager_id' => $otherManager->id,
        ]);

        $this->actingAs($manager);

        $response = $this->put(route('manager.shop.update', $shop->id), [
            'name' => 'Hacked Shop Name',
            'area' => $shop->area,
            'genre' => $shop->genre,
            'description' => $shop->description,
            'max_capacity' => $shop->max_capacity,
        ]);

        $response->assertStatus(403);
    }
}
