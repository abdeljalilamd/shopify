<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCartItemsTest extends TestCase
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
    public function it_gets_product_cart_items(): void
    {
        $product = Product::factory()->create();
        $cartItems = CartItem::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.cart-items.index', $product)
        );

        $response->assertOk()->assertSee($cartItems[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_product_cart_items(): void
    {
        $product = Product::factory()->create();
        $data = CartItem::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.cart-items.store', $product),
            $data
        );

        unset($data['cart_id']);

        $this->assertDatabaseHas('cart_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cartItem = CartItem::latest('id')->first();

        $this->assertEquals($product->id, $cartItem->product_id);
    }
}
