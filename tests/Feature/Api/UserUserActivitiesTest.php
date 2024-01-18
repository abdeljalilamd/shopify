<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserActivitie;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUserActivitiesTest extends TestCase
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
    public function it_gets_user_user_activities(): void
    {
        $user = User::factory()->create();
        $userActivities = UserActivitie::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.user-activities.index', $user)
        );

        $response->assertOk()->assertSee($userActivities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_user_activities(): void
    {
        $user = User::factory()->create();
        $data = UserActivitie::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.user-activities.store', $user),
            $data
        );

        $this->assertDatabaseHas('user_activities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $userActivitie = UserActivitie::latest('id')->first();

        $this->assertEquals($user->id, $userActivitie->user_id);
    }
}
