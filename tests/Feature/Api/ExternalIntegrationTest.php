<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ExternalIntegration;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExternalIntegrationTest extends TestCase
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
    public function it_gets_external_integrations_list(): void
    {
        $externalIntegrations = ExternalIntegration::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.external-integrations.index'));

        $response->assertOk()->assertSee($externalIntegrations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_external_integration(): void
    {
        $data = ExternalIntegration::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.external-integrations.store'),
            $data
        );

        $this->assertDatabaseHas('external_integrations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.external-integrations.update', $externalIntegration),
            $data
        );

        $data['id'] = $externalIntegration->id;

        $this->assertDatabaseHas('external_integrations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_external_integration(): void
    {
        $externalIntegration = ExternalIntegration::factory()->create();

        $response = $this->deleteJson(
            route('api.external-integrations.destroy', $externalIntegration)
        );

        $this->assertModelMissing($externalIntegration);

        $response->assertNoContent();
    }
}
