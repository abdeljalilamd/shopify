<?php

namespace Database\Factories;

use App\Models\SeoMeta;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeoMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SeoMeta::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'key' => $this->faker->text(255),
            'seo_setting_id' => \App\Models\SeoSetting::factory(),
        ];
    }
}
