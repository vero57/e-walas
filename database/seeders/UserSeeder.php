<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('user'),
            'email_verified_at' => now(),
        ]);
    }
}