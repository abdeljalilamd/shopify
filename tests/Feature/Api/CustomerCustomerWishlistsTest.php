<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerWishlist;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerCustomerWishlistsTest extends TestCase
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
    public function it_gets_customer_customer_wishlists(): void
    {
        $customer = Customer::factory()->create();
        $customerWishlists = CustomerWishlist::factory()
            ->count(2)
            ->create([
                'customer_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.customer-wishlists.index', $customer)
        );

        $response->assertOk()->assertSee($customerWishlists[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_customer_wishlists(): void
    {
        $customer = Customer::factory()->create();
        $data = CustomerWishlist::factory()
            ->make([
                'customer_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.customer-wishlists.store', $customer),
            $data
        );

        unset($data['customer_id']);

        $this->assertDatabaseHas('customer_wishlists', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $customerWishlist = CustomerWishlist::latest('id')->first();

        $this->assertEquals($customer->id, $customerWishlist->customer_id);
    }
}
