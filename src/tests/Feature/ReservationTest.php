<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログインユーザーは予約できる()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create([
            'max_capacity' => 5,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('reservation.store'), [
            'shop_id' => $shop->id,
            'reservation_date' => '2025-12-25',
            'time_slot' => '18:00',
            'num_of_people' => 2,
        ]);

        $response->assertRedirect(route('reservation.complete'));

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'reservation_date' => '2025-12-25',
            'time_slot' => '18:00:00',
            'num_of_people' => 2,
        ]);
    }

    /** @test */
    public function 未ログインの場合は予約できない()
    {
        $shop = Shop::factory()->create();

        $response = $this->post(route('reservation.store'), [
            'shop_id' => $shop->id,
            'reservation_date' => '2025-12-25',
            'time_slot' => '18:00',
            'num_of_people' => 2,
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'reservation_date' => '2025-12-25',
            'time_slot' => '18:00',
            'num_of_people' => 2,
        ]);
    }

    /** @test */
    public function 他人の予約は変更できない()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user);

        $response = $this->put(route('reservation.update', $reservation->id), ['num_of_people' => 3]);

        $response->assertStatus(403);
    }

    /** @test */
    public function 他人の予約はキャンセルできない()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('reservation.cancel'), [
            'reservation_id' => $reservation->id,
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
        ]);
    }

    /** @test */
    public function 同じ日時・同じ店舗では予約できない()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $shop = Shop::factory()->create();

        Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'reservation_date' => '2025-12-25',
            'time_slot' => '18:00',
        ]);

        $response = $this->post(route('reservation.store'), [
            'shop_id' => $shop->id,
            'reservation_date' => '2025-12-25',
            'time_slot' => '18:00',
            'num_of_people' => 2,
        ]);

        $response->assertSessionHasErrors();

        $this->assertCount(1, Reservation::all());
    }


    /** @test */
    public function QRコードが正しく生成される()
    {
        $reservation = Reservation::factory()->create();
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $ngrokUrl = 'https://example.ngrok.io';
        putenv("NGROK_URL=$ngrokUrl");

        $response = $this->get(route('reservation.qr', $reservation->id));

        $response->assertStatus(200);
        $response->assertViewHas(
            'qrUrl',
            'https://example.ngrok.io/reservation/' . $reservation->id . '/verify'
        );
    }
}
