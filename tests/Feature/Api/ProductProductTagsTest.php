<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductTag;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductTagsTest extends TestCase
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
    public function it_gets_product_product_tags(): void
    {
        $product = Product::factory()->create();
        $productTags = ProductTag::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.product-tags.index', $product)
        );

        $response->assertOk()->assertSee($productTags[0]->tag);
    }

    /**
     * @test
     */
    public function it_stores_the_product_product_tags(): void
    {
        $product = Product::factory()->create();
        $data = ProductTag::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.product-tags.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('product_tags', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productTag = ProductTag::latest('id')->first();

        $this->assertEquals($product->id, $productTag->product_id);
    }
}
