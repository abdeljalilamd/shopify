<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductAttribute;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductAttributesTest extends TestCase
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
    public function it_gets_product_product_attributes(): void
    {
        $product = Product::factory()->create();
        $productAttributes = ProductAttribute::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.product-attributes.index', $product)
        );

        $response->assertOk()->assertSee($productAttributes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_product_attributes(): void
    {
        $product = Product::factory()->create();
        $data = ProductAttribute::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.product-attributes.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('product_attributes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productAttribute = ProductAttribute::latest('id')->first();

        $this->assertEquals($product->id, $productAttribute->product_id);
    }
}
