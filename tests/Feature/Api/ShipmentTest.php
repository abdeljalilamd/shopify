<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shipment;

use App\Models\Order;
use App\Models\ShippingMethod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipmentTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_shipments_list(): void
    {
        $shipments = Shipment::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.shipments.index'));

        $response->assertOk()->assertSee($shipments[0]->tracking_number);
    }

    /**
     * @test
     */
    public function it_stores_the_shipment(): void
    {
        $data = Shipment::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.shipments.store'), $data);

        $this->assertDatabaseHas('shipments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_shipment(): void
    {
        $shipment = Shipment::factory()->create();

        $order = Order::factory()->create();
        $shippingMethod = ShippingMethod::factory()->create();

        $data = [
            'tracking_number' => $this->faker->text(255),
            'order_id' => $order->id,
            'shipping_method_id' => $shippingMethod->id,
        ];

        $response = $this->putJson(
            route('api.shipments.update', $shipment),
            $data
        );

        $data['id'] = $shipment->id;

        $this->assertDatabaseHas('shipments', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_shipment(): void
    {
        $shipment = Shipment::factory()->create();

        $response = $this->deleteJson(
            route('api.shipments.destroy', $shipment)
        );

        $this->assertModelMissing($shipment);

        $response->assertNoContent();
    }
}
