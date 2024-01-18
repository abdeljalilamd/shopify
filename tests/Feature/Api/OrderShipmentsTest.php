<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Shipment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderShipmentsTest extends TestCase
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
    public function it_gets_order_shipments(): void
    {
        $order = Order::factory()->create();
        $shipments = Shipment::factory()
            ->count(2)
            ->create([
                'order_id' => $order->id,
            ]);

        $response = $this->getJson(route('api.orders.shipments.index', $order));

        $response->assertOk()->assertSee($shipments[0]->tracking_number);
    }

    /**
     * @test
     */
    public function it_stores_the_order_shipments(): void
    {
        $order = Order::factory()->create();
        $data = Shipment::factory()
            ->make([
                'order_id' => $order->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.orders.shipments.store', $order),
            $data
        );

        $this->assertDatabaseHas('shipments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $shipment = Shipment::latest('id')->first();

        $this->assertEquals($order->id, $shipment->order_id);
    }
}
