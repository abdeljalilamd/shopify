<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Shipment;
use App\Models\ShippingMethod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShippingMethodShipmentsTest extends TestCase
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
    public function it_gets_shipping_method_shipments(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();
        $shipments = Shipment::factory()
            ->count(2)
            ->create([
                'shipping_method_id' => $shippingMethod->id,
            ]);

        $response = $this->getJson(
            route('api.shipping-methods.shipments.index', $shippingMethod)
        );

        $response->assertOk()->assertSee($shipments[0]->tracking_number);
    }

    /**
     * @test
     */
    public function it_stores_the_shipping_method_shipments(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();
        $data = Shipment::factory()
            ->make([
                'shipping_method_id' => $shippingMethod->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.shipping-methods.shipments.store', $shippingMethod),
            $data
        );

        $this->assertDatabaseHas('shipments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $shipment = Shipment::latest('id')->first();

        $this->assertEquals($shippingMethod->id, $shipment->shipping_method_id);
    }
}
