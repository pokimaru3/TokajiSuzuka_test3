<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 予約者本人は評価画面を開ける()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('reviews.create', $reservation->id));

        $response->assertStatus(200);
    }

    /** @test */
    public function 他人はレビュー評価画面を開けない()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $shop = Shop::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $this->actingAs($otherUser);

        $response = $this->get(route('reviews.create', $reservation->id));

        $response->assertStatus(403);
    }

    /** @test */
    public function レビューを投稿できる()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('reviews.store', $reservation->id), [
            'rating' => 5,
            'comment' => 'Good',
        ]);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'reservation_id' => $reservation->id,
            'rating' => 5,
            'comment' => 'Good',
        ]);
    }
}
