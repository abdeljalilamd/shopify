<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(2, 0, 9999),
            'coupon_code' => $this->faker->text(255),
        ];
    }
}
