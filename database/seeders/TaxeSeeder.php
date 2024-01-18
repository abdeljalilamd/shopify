<?php

namespace Database\Seeders;

use App\Models\Taxe;
use Illuminate\Database\Seeder;

class TaxeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Taxe::factory()
            ->count(5)
            ->create();
    }
}
