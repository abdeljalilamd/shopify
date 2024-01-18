<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductReview::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->randomNumber(0),
            'text' => $this->faker->text(),
            'product_id' => \App\Models\Product::factory(),
            'customer_id' => \App\Models\Customer::factory(),
        ];
    }
}
