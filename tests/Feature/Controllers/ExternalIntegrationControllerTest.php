<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ExternalIntegration;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExternalIntegrationControllerTest extends TestCase
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
    public function it_displays_index_view_with_external_integrations(): void
    {
        $externalIntegrations = ExternalIntegration::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('external-integrations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.external_integrations.index')
            ->assertViewHas('externalIntegrations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_external_integration(): void
    {
        $response = $this->get(route('external-integrations.create'));

        $response->assertOk()->assertViewIs('app.external_integrations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_external_integration(): void
    {
        $data = ExternalIntegration::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('external-integrations.store'), $data);

        $this->assertDatabaseHas('external_integrations', $data);

        $externalIntegration = ExternalIntegration::latest('id')->first();

        $response->assertRedirect(
            route('external-integrations.edit', $externalIntegration)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_external_integration(): void
    {
        $externalIntegration = ExternalIntegration::factory()->create();

        $response = $this->get(
            route('external-integrations.show', $externalIntegration)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.external_integrations.show')
            ->assertViewHas('externalIntegration');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_external_integration(): void
    {
        $externalIntegration = ExternalIntegration::factory()->create();

        $response = $this->get(
            route('external-integrations.edit', $externalIntegration)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.external_integrations.edit')
            ->assertViewHas('externalIntegration');
    }

    /**
     * @test
     */
    public function it_updates_the_external_integration(): void
    {
        $externalIntegration = ExternalIntegration::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'api_key' => $this->faker->text(255),
            'token' => $this->faker->text(255),
        ];

        $response = $this->put(
            route('external-integrations.update', $externalIntegration),
            $data
        );

        $data['id'] = $externalIntegration->id;

        $this->assertDatabaseHas('external_integrations', $data);

        $response->assertRedirect(
            route('external-integrations.edit', $externalIntegration)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_external_integration(): void
    {
        $externalIntegration = ExternalIntegration::factory()->create();

        $response = $this->delete(
            route('external-integrations.destroy', $externalIntegration)
        );

        $response->assertRedirect(route('external-integrations.index'));

        $this->assertModelMissing($externalIntegration);
    }
}
