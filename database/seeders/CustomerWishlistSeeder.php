<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerWishlist;

class CustomerWishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerWishlist::factory()
            ->count(5)
            ->create();
    }
}
