<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AffiliateProgram;

class AffiliateProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AffiliateProgram::factory()
            ->count(5)
            ->create();
    }
}
