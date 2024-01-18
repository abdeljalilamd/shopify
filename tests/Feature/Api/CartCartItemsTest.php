<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartCartItemsTest extends TestCase
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
    public function it_gets_cart_cart_items(): void
    {
        $cart = Cart::factory()->create();
        $cartItems = CartItem::factory()
            ->count(2)
            ->create([
                'cart_id' => $cart->id,
            ]);

        $response = $this->getJson(route('api.carts.cart-items.index', $cart));

        $response->assertOk()->assertSee($cartItems[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_cart_cart_items(): void
    {
        $cart = Cart::factory()->create();
        $data = CartItem::factory()
            ->make([
                'cart_id' => $cart->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.carts.cart-items.store', $cart),
            $data
        );

        unset($data['cart_id']);

        $this->assertDatabaseHas('cart_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cartItem = CartItem::latest('id')->first();

        $this->assertEquals($cart->id, $cartItem->cart_id);
    }
}
