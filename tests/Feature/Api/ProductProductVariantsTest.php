<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductVariantsTest extends TestCase
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
    public function it_gets_product_product_variants(): void
    {
        $product = Product::factory()->create();
        $productVariants = ProductVariant::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.product-variants.index', $product)
        );

        $response->assertOk()->assertSee($productVariants[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_product_variants(): void
    {
        $product = Product::factory()->create();
        $data = ProductVariant::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.product-variants.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('product_variants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productVariant = ProductVariant::latest('id')->first();

        $this->assertEquals($product->id, $productVariant->product_id);
    }
}
