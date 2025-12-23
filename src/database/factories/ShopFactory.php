<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Shop;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'area' => '東京',
            'genre' => '寿司',
            'max_capacity' => 5,
            'description' => $this->faker->text(100),
        ];
    }
}
