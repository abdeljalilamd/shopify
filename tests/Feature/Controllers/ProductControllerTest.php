<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Product;

use App\Models\Categorie;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_products(): void
    {
        $products = Product::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('products.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.products.index')
            ->assertViewHas('products');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product(): void
    {
        $response = $this->get(route('products.create'));

        $response->assertOk()->assertViewIs('app.products.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product(): void
    {
        $data = Product::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('products.store'), $data);

        $this->assertDatabaseHas('products', $data);

        $product = Product::latest('id')->first();

        $response->assertRedirect(route('products.edit', $product));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response
            ->assertOk()
            ->assertViewIs('app.products.show')
            ->assertViewHas('product');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response
            ->assertOk()
            ->assertViewIs('app.products.edit')
            ->assertViewHas('product');
    }

    /**
     * @test
     */
    public function it_updates_the_product(): void
    {
        $product = Product::factory()->create();

        $categorie = Categorie::factory()->create();

        $data = [
            'title' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'content' => $this->faker->text(),
            'categorie_id' => $categorie->id,
        ];

        $response = $this->put(route('products.update', $product), $data);

        $data['id'] = $product->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertRedirect(route('products.edit', $product));
    }

    /**
     * @test
     */
    public function it_deletes_the_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));

        $this->assertModelMissing($product);
    }
}
