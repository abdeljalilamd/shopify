<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExternalIntegration;

class ExternalIntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExternalIntegration::factory()
            ->count(5)
            ->create();
    }
}
