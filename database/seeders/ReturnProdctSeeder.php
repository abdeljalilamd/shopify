<?php

namespace Database\Seeders;

use App\Models\ReturnProdct;
use Illuminate\Database\Seeder;

class ReturnProdctSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReturnProdct::factory()
            ->count(5)
            ->create();
    }
}
