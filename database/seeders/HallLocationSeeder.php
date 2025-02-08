<?php

namespace Database\Seeders;

use App\Models\HallLocation;
use Illuminate\Database\Seeder;

class HallLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HallLocation::class::factory()->create(
            [
                'location' => 'Research Building',
                'status' => 'active',
            ]
        );

        HallLocation::class::factory()->create(
            [
                'location' => 'SACTD',
                'status' => 'active',
            ]
        );

        HallLocation::class::factory()->create(
            [
                'location' => 'SAT',
                'status' => 'active',
            ]
        );

        HallLocation::class::factory()->create(
            [
                'location' => 'TRACE',
                'status' => 'active',
            ]
        );

        HallLocation::class::factory()->create(
            [
                'location' => 'Main Hall',
                'status' => 'active',
            ]
        );

    }
}
