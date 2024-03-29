<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Shipment;

use App\Models\Order;
use App\Models\ShippingMethod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShipmentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_shipments(): void
    {
        $shipments = Shipment::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shipments.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.shipments.index')
            ->assertViewHas('shipments');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shipment(): void
    {
        $response = $this->get(route('shipments.create'));

        $response->assertOk()->assertViewIs('app.shipments.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shipment(): void
    {
        $data = Shipment::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shipments.store'), $data);

        $this->assertDatabaseHas('shipments', $data);

        $shipment = Shipment::latest('id')->first();

        $response->assertRedirect(route('shipments.edit', $shipment));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shipment(): void
    {
        $shipment = Shipment::factory()->create();

        $response = $this->get(route('shipments.show', $shipment));

        $response
            ->assertOk()
            ->assertViewIs('app.shipments.show')
            ->assertViewHas('shipment');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shipment(): void
    {
        $shipment = Shipment::factory()->create();

        $response = $this->get(route('shipments.edit', $shipment));

        $response
            ->assertOk()
            ->assertViewIs('app.shipments.edit')
            ->assertViewHas('shipment');
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

        $response = $this->put(route('shipments.update', $shipment), $data);

        $data['id'] = $shipment->id;

        $this->assertDatabaseHas('shipments', $data);

        $response->assertRedirect(route('shipments.edit', $shipment));
    }

    /**
     * @test
     */
    public function it_deletes_the_shipment(): void
    {
        $shipment = Shipment::factory()->create();

        $response = $this->delete(route('shipments.destroy', $shipment));

        $response->assertRedirect(route('shipments.index'));

        $this->assertModelMissing($shipment);
    }
}
