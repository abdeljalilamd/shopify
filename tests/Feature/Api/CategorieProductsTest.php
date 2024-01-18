<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Categorie;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorieProductsTest extends TestCase
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
    public function it_gets_categorie_products(): void
    {
        $categorie = Categorie::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'categorie_id' => $categorie->id,
            ]);

        $response = $this->getJson(
            route('api.categories.products.index', $categorie)
        );

        $response->assertOk()->assertSee($products[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_categorie_products(): void
    {
        $categorie = Categorie::factory()->create();
        $data = Product::factory()
            ->make([
                'categorie_id' => $categorie->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.categories.products.store', $categorie),
            $data
        );

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($categorie->id, $product->categorie_id);
    }
}
