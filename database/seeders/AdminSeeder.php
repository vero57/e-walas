<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        Admin::create([
            'nama' => 'admin',
            'no_wa' => $faker->numerify('08##########'),
            'password' => Hash::make('admin'),
        ]);
    }
}