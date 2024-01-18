<?php

namespace Database\Factories;

use App\Models\Refund;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refund::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 9999),
            'returnProdct_id' => \App\Models\ReturnProdct::factory(),
        ];
    }
}
