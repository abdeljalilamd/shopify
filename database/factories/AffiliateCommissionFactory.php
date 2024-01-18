<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AffiliateCommission;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateCommissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AffiliateCommission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 0, 9999),
            'affiliate_program_id' => \App\Models\AffiliateProgram::factory(),
        ];
    }
}
