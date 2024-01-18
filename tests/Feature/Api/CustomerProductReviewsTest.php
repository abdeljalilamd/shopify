<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\ProductReview;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerProductReviewsTest extends TestCase
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
    public function it_gets_customer_product_reviews(): void
    {
        $customer = Customer::factory()->create();
        $productReviews = ProductReview::factory()
            ->count(2)
            ->create([
                'customer_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.product-reviews.index', $customer)
        );

        $response->assertOk()->assertSee($productReviews[0]->text);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_product_reviews(): void
    {
        $customer = Customer::factory()->create();
        $data = ProductReview::factory()
            ->make([
                'customer_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.product-reviews.store', $customer),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('product_reviews', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productReview = ProductReview::latest('id')->first();

        $this->assertEquals($customer->id, $productReview->customer_id);
    }
}
