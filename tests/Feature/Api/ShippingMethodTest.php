<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ShippingMethod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShippingMethodTest extends TestCase
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
    public function it_gets_shipping_methods_list(): void
    {
        $shippingMethods = ShippingMethod::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.shipping-methods.index'));

        $response->assertOk()->assertSee($shippingMethods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_shipping_method(): void
    {
        $data = ShippingMethod::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.shipping-methods.store'), $data);

        $this->assertDatabaseHas('shipping_methods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.shipping-methods.update', $shippingMethod),
            $data
        );

        $data['id'] = $shippingMethod->id;

        $this->assertDatabaseHas('shipping_methods', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_shipping_method(): void
    {
        $shippingMethod = ShippingMethod::factory()->create();

        $response = $this->deleteJson(
            route('api.shipping-methods.destroy', $shippingMethod)
        );

        $this->assertModelMissing($shippingMethod);

        $response->assertNoContent();
    }
}
