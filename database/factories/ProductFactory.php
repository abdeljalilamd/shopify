<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'content' => $this->faker->text(),
            'categorie_id' => \App\Models\Categorie::factory(),
        ];
    }
}
