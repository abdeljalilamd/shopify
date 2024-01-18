<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CustomerWishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerWishlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerWishlist::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customer::factory(),
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}
