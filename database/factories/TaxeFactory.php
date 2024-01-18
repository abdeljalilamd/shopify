<?php

namespace Database\Factories;

use App\Models\Taxe;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taxe::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'rate' => $this->faker->randomFloat(2, 0, 9999),
        ];
    }
}
