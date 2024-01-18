<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Setting;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingTest extends TestCase
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
    public function it_gets_settings_list(): void
    {
        $settings = Setting::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.settings.index'));

        $response->assertOk()->assertSee($settings[0]->key);
    }

    /**
     * @test
     */
    public function it_stores_the_setting(): void
    {
        $data = Setting::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.settings.store'), $data);

        $this->assertDatabaseHas('settings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_setting(): void
    {
        $setting = Setting::factory()->create();

        $data = [
            'key' => $this->faker->text(255),
            'value' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.settings.update', $setting),
            $data
        );

        $data['id'] = $setting->id;

        $this->assertDatabaseHas('settings', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_setting(): void
    {
        $setting = Setting::factory()->create();

        $response = $this->deleteJson(route('api.settings.destroy', $setting));

        $this->assertModelMissing($setting);

        $response->assertNoContent();
    }
}
