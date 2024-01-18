<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Taxe;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaxeTest extends TestCase
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
    public function it_gets_taxes_list(): void
    {
        $taxes = Taxe::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.taxes.index'));

        $response->assertOk()->assertSee($taxes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_taxe(): void
    {
        $data = Taxe::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.taxes.store'), $data);

        $this->assertDatabaseHas('taxes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.taxes.update', $taxe), $data);

        $data['id'] = $taxe->id;

        $this->assertDatabaseHas('taxes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_taxe(): void
    {
        $taxe = Taxe::factory()->create();

        $response = $this->deleteJson(route('api.taxes.destroy', $taxe));

        $this->assertModelMissing($taxe);

        $response->assertNoContent();
    }
}
