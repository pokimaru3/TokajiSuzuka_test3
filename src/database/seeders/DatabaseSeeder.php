<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ShopsTableSeeder::class,
            AdminUserSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
