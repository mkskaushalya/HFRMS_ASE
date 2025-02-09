<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\HallBooking;
use App\Models\HallImage;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Sahan',
            'lastname' => 'Kaushalya',
            'phone' => '0787520742',
            'profile_picture' => '/img/avatar.png',
            'address' => 'Kosgama, Sri Lanka',
            'email' => 'mkskaushalya@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        //Admin User
        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'phone' => '0752575325',
            'profile_picture' => '/img/avatar.png',
            'address' => 'Kosgama, Sri Lanka',
            'email' => 'admin@tute.lk',
            'password' => bcrypt('12345678'),
            'usertype' => 'admin',
        ]);

        User::factory(10)->create();
        
        $this->call(HallLocationSeeder::class);
        Hall::factory(10)->create();
        HallImage::factory(50)->create();
        Review::factory(50)->create();
        HallBooking::factory(50)->create();
    }
}
