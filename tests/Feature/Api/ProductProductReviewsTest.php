<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductReview;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductReviewsTest extends TestCase
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
    public function it_gets_product_product_reviews(): void
    {
        $product = Product::factory()->create();
        $productReviews = ProductReview::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.product-reviews.index', $product)
        );

        $response->assertOk()->assertSee($productReviews[0]->text);
    }

    /**
     * @test
     */
    public function it_stores_the_product_product_reviews(): void
    {
        $product = Product::factory()->create();
        $data = ProductReview::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.product-reviews.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('product_reviews', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productReview = ProductReview::latest('id')->first();

        $this->assertEquals($product->id, $productReview->product_id);
    }
}
