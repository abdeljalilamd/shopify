<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\UserActivitie;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivitieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserActivitie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'type' => $this->faker->word(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
