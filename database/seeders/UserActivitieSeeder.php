<?php

namespace Database\Seeders;

use App\Models\UserActivitie;
use Illuminate\Database\Seeder;

class UserActivitieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserActivitie::factory()
            ->count(5)
            ->create();
    }
}
