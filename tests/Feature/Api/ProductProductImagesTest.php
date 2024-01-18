<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductImagesTest extends TestCase
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
    public function it_gets_product_product_images(): void
    {
        $product = Product::factory()->create();
        $productImages = ProductImage::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.product-images.index', $product)
        );

        $response->assertOk()->assertSee($productImages[0]->image_url);
    }

    /**
     * @test
     */
    public function it_stores_the_product_product_images(): void
    {
        $product = Product::factory()->create();
        $data = ProductImage::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.product-images.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('product_images', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productImage = ProductImage::latest('id')->first();

        $this->assertEquals($product->id, $productImage->product_id);
    }
}
