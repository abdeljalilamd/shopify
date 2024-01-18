<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ShippingMethod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShippingMethodControllerTest extends TestCase
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
    public function it_displays_index_view_with_shipping_methods(): void
    {
        $shippingMethods = ShippingMethod::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shipping-methods.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.shipping_methods.index')
            ->assertViewHas('shippingMethods');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shipping_method(): void
    {
        $response = $this->get(route('shipping-methods.create'));

        $response->assertOk()->assertViewIs('app.shipping_methods.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shipping_method(): void
    {
        $data = ShippingMethod::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shipping-methods.store'), $data);

        $this->assertDatabaseHas('shipping_methods', $data);

        $shippingMethod = ShippingMethod::latest('id')->first();

        $response->assertRedirect(
            route('shipping-methods.edit', $shippingMethod)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shipping_method(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();

        $response = $this->get(route('shipping-methods.show', $shippingMethod));

        $response
            ->assertOk()
            ->assertViewIs('app.shipping_methods.show')
            ->assertViewHas('shippingMethod');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shipping_method(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();

        $response = $this->get(route('shipping-methods.edit', $shippingMethod));

        $response
            ->assertOk()
            ->assertViewIs('app.shipping_methods.edit')
            ->assertViewHas('shippingMethod');
    }

    /**
     * @test
     */
    public function it_updates_the_shipping_method(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'cost' => $this->faker->randomFloat(2, 0, 9999),
        ];

        $response = $this->put(
            route('shipping-methods.update', $shippingMethod),
            $data
        );

        $data['id'] = $shippingMethod->id;

        $this->assertDatabaseHas('shipping_methods', $data);

        $response->assertRedirect(
            route('shipping-methods.edit', $shippingMethod)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_shipping_method(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();

        $response = $this->delete(
            route('shipping-methods.destroy', $shippingMethod)
        );

        $response->assertRedirect(route('shipping-methods.index'));

        $this->assertModelMissing($shippingMethod);
    }
}
