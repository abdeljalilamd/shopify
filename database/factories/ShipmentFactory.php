<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_number' => $this->faker->text(255),
            'order_id' => \App\Models\Order::factory(),
            'shipping_method_id' => \App\Models\ShippingMethod::factory(),
        ];
    }
}
