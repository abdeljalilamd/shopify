<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserActivitie;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserActivitieControllerTest extends TestCase
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
    public function it_displays_index_view_with_user_activities(): void
    {
        $userActivities = UserActivitie::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('user-activities.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.user_activities.index')
            ->assertViewHas('userActivities');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_user_activitie(): void
    {
        $response = $this->get(route('user-activities.create'));

        $response->assertOk()->assertViewIs('app.user_activities.create');
    }

    /**
     * @test
     */
    public function it_stores_the_user_activitie(): void
    {
        $data = UserActivitie::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('user-activities.store'), $data);

        $this->assertDatabaseHas('user_activities', $data);

        $userActivitie = UserActivitie::latest('id')->first();

        $response->assertRedirect(
            route('user-activities.edit', $userActivitie)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_user_activitie(): void
    {
        $userActivitie = UserActivitie::factory()->create();

        $response = $this->get(route('user-activities.show', $userActivitie));

        $response
            ->assertOk()
            ->assertViewIs('app.user_activities.show')
            ->assertViewHas('userActivitie');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_user_activitie(): void
    {
        $userActivitie = UserActivitie::factory()->create();

        $response = $this->get(route('user-activities.edit', $userActivitie));

        $response
            ->assertOk()
            ->assertViewIs('app.user_activities.edit')
            ->assertViewHas('userActivitie');
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

        $response = $this->put(
            route('user-activities.update', $userActivitie),
            $data
        );

        $data['id'] = $userActivitie->id;

        $this->assertDatabaseHas('user_activities', $data);

        $response->assertRedirect(
            route('user-activities.edit', $userActivitie)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_user_activitie(): void
    {
        $userActivitie = UserActivitie::factory()->create();

        $response = $this->delete(
            route('user-activities.destroy', $userActivitie)
        );

        $response->assertRedirect(route('user-activities.index'));

        $this->assertModelMissing($userActivitie);
    }
}
