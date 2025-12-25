<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 店舗代表者（manager）
        User::create([
            'name' => 'Manager1',
            'email' => 'manager1@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Manager2',
            'email' => 'manager2@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // 一般ユーザー（user）
        User::create([
            'name' => 'User1',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
