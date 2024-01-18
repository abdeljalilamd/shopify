<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Taxe;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaxeControllerTest extends TestCase
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
    public function it_displays_index_view_with_taxes(): void
    {
        $taxes = Taxe::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('taxes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.taxes.index')
            ->assertViewHas('taxes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_taxe(): void
    {
        $response = $this->get(route('taxes.create'));

        $response->assertOk()->assertViewIs('app.taxes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_taxe(): void
    {
        $data = Taxe::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('taxes.store'), $data);

        $this->assertDatabaseHas('taxes', $data);

        $taxe = Taxe::latest('id')->first();

        $response->assertRedirect(route('taxes.edit', $taxe));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_taxe(): void
    {
        $taxe = Taxe::factory()->create();

        $response = $this->get(route('taxes.show', $taxe));

        $response
            ->assertOk()
            ->assertViewIs('app.taxes.show')
            ->assertViewHas('taxe');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_taxe(): void
    {
        $taxe = Taxe::factory()->create();

        $response = $this->get(route('taxes.edit', $taxe));

        $response
            ->assertOk()
            ->assertViewIs('app.taxes.edit')
            ->assertViewHas('taxe');
    }

    /**
     * @test
     */
    public function it_updates_the_taxe(): void
    {
        $taxe = Taxe::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'rate' => $this->faker->randomFloat(2, 0, 9999),
        ];

        $response = $this->put(route('taxes.update', $taxe), $data);

        $data['id'] = $taxe->id;

        $this->assertDatabaseHas('taxes', $data);

        $response->assertRedirect(route('taxes.edit', $taxe));
    }

    /**
     * @test
     */
    public function it_deletes_the_taxe(): void
    {
        $taxe = Taxe::factory()->create();

        $response = $this->delete(route('taxes.destroy', $taxe));

        $response->assertRedirect(route('taxes.index'));

        $this->assertModelMissing($taxe);
    }
}
