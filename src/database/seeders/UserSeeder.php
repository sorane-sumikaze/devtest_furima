<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'user_name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified' => true,
        ]);
    }
}
