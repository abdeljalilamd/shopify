<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\AffiliateProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateProgramFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AffiliateProgram::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commission' => $this->faker->randomFloat(2, 0, 9999),
            'affiliate_id' => \App\Models\Customer::factory(),
            'referral_id' => \App\Models\Customer::factory(),
        ];
    }
}
