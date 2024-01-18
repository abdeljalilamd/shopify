<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AffiliateCommission;

class AffiliateCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AffiliateCommission::factory()
            ->count(5)
            ->create();
    }
}
