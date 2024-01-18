<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Categorie;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorieTest extends TestCase
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
    public function it_gets_categories_list(): void
    {
        $categories = Categorie::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.categories.index'));

        $response->assertOk()->assertSee($categories[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_categorie(): void
    {
        $data = Categorie::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.categories.store'), $data);

        $this->assertDatabaseHas('categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.categories.update', $categorie),
            $data
        );

        $data['id'] = $categorie->id;

        $this->assertDatabaseHas('categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_categorie(): void
    {
        $categorie = Categorie::factory()->create();

        $response = $this->deleteJson(
            route('api.categories.destroy', $categorie)
        );

        $this->assertModelMissing($categorie);

        $response->assertNoContent();
    }
}
