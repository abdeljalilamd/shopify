<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ReturnProdct;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReturnProdctFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReturnProdct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reason' => $this->faker->text(),
            'order_id' => \App\Models\Order::factory(),
        ];
    }
}
