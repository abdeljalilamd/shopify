<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SocialMediaLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialMediaLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialMediaLink::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'platform' => $this->faker->text(255),
            'url' => $this->faker->url(),
            'setting_id' => \App\Models\Setting::factory(),
        ];
    }
}
