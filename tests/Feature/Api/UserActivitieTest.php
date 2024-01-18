<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserActivitie;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserActivitieTest extends TestCase
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
    public function it_gets_user_activities_list(): void
    {
        $userActivities = UserActivitie::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.user-activities.index'));

        $response->assertOk()->assertSee($userActivities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_activitie(): void
    {
        $data = UserActivitie::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.user-activities.store'), $data);

        $this->assertDatabaseHas('user_activities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_user_activitie(): void
    {
        $userActivitie = UserActivitie::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'type' => $this->faker->word(),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.user-activities.update', $userActivitie),
            $data
        );

        $data['id'] = $userActivitie->id;

        $this->assertDatabaseHas('user_activities', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_user_activitie(): void
    {
        $userActivitie = UserActivitie::factory()->create();

        $response = $this->deleteJson(
            route('api.user-activities.destroy', $userActivitie)
        );

        $this->assertModelMissing($userActivitie);

        $response->assertNoContent();
    }
}
