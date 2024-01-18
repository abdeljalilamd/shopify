<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Categorie;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorieControllerTest extends TestCase
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
    public function it_displays_index_view_with_categories(): void
    {
        $categories = Categorie::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('categories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.categories.index')
            ->assertViewHas('categories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_categorie(): void
    {
        $response = $this->get(route('categories.create'));

        $response->assertOk()->assertViewIs('app.categories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_categorie(): void
    {
        $data = Categorie::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('categories.store'), $data);

        $this->assertDatabaseHas('categories', $data);

        $categorie = Categorie::latest('id')->first();

        $response->assertRedirect(route('categories.edit', $categorie));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_categorie(): void
    {
        $categorie = Categorie::factory()->create();

        $response = $this->get(route('categories.show', $categorie));

        $response
            ->assertOk()
            ->assertViewIs('app.categories.show')
            ->assertViewHas('categorie');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_categorie(): void
    {
        $categorie = Categorie::factory()->create();

        $response = $this->get(route('categories.edit', $categorie));

        $response
            ->assertOk()
            ->assertViewIs('app.categories.edit')
            ->assertViewHas('categorie');
    }

    /**
     * @test
     */
    public function it_updates_the_categorie(): void
    {
        $categorie = Categorie::factory()->create();

        $data = [
            'title' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'slug' => $this->faker->slug(),
        ];

        $response = $this->put(route('categories.update', $categorie), $data);

        $data['id'] = $categorie->id;

        $this->assertDatabaseHas('categories', $data);

        $response->assertRedirect(route('categories.edit', $categorie));
    }

    /**
     * @test
     */
    public function it_deletes_the_categorie(): void
    {
        $categorie = Categorie::factory()->create();

        $response = $this->delete(route('categories.destroy', $categorie));

        $response->assertRedirect(route('categories.index'));

        $this->assertModelMissing($categorie);
    }
}
