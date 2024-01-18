<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\CustomerWishlist;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCustomerWishlistsTest extends TestCase
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
    public function it_gets_product_customer_wishlists(): void
    {
        $product = Product::factory()->create();
        $customerWishlists = CustomerWishlist::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.customer-wishlists.index', $product)
        );

        $response->assertOk()->assertSee($customerWishlists[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_customer_wishlists(): void
    {
        $product = Product::factory()->create();
        $data = CustomerWishlist::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.customer-wishlists.store', $product),
            $data
        );

        unset($data['customer_id']);

        $this->assertDatabaseHas('customer_wishlists', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $customerWishlist = CustomerWishlist::latest('id')->first();

        $this->assertEquals($product->id, $customerWishlist->product_id);
    }
}
