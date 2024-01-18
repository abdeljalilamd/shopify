<?php

namespace Database\Factories;

use App\Models\SeoSetting;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeoSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeoSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meta_description' => $this->faker->text(),
        ];
    }
}
