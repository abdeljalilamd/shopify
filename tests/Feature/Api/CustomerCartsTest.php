<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cart;
use App\Models\Customer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerCartsTest extends TestCase
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
    public function it_gets_customer_carts(): void
    {
        $customer = Customer::factory()->create();
        $carts = Cart::factory()
            ->count(2)
            ->create([
                'customer_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.carts.index', $customer)
        );

        $response->assertOk()->assertSee($carts[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_carts(): void
    {
        $customer = Customer::factory()->create();
        $data = Cart::factory()
            ->make([
                'customer_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.carts.store', $customer),
            $data
        );

        $this->assertDatabaseHas('carts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cart = Cart::latest('id')->first();

        $this->assertEquals($customer->id, $cart->customer_id);
    }
}
