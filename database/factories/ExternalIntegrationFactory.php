<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ExternalIntegration;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExternalIntegrationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExternalIntegration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'api_key' => $this->faker->text(255),
            'token' => $this->faker->text(255),
        ];
    }
}
