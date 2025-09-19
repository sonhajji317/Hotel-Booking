<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoomTypeSeeder::class,
            HotelSeeder::class,
            RoomSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin Melawai',
            'email' => 'admin@melawai.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
