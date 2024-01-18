<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SeoSetting;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeoSettingTest extends TestCase
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
    public function it_gets_seo_settings_list(): void
    {
        $seoSettings = SeoSetting::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.seo-settings.index'));

        $response->assertOk()->assertSee($seoSettings[0]->meta_description);
    }

    /**
     * @test
     */
    public function it_stores_the_seo_setting(): void
    {
        $data = SeoSetting::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.seo-settings.store'), $data);

        $this->assertDatabaseHas('seo_settings', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_seo_setting(): void
    {
        $seoSetting = SeoSetting::factory()->create();

        $data = [
            'meta_description' => $this->faker->text(),
        ];

        $response = $this->putJson(
            route('api.seo-settings.update', $seoSetting),
            $data
        );

        $data['id'] = $seoSetting->id;

        $this->assertDatabaseHas('seo_settings', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_seo_setting(): void
    {
        $seoSetting = SeoSetting::factory()->create();

        $response = $this->deleteJson(
            route('api.seo-settings.destroy', $seoSetting)
        );

        $this->assertModelMissing($seoSetting);

        $response->assertNoContent();
    }
}
