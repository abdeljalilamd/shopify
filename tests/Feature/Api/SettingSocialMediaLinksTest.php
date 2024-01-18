<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Setting;
use App\Models\SocialMediaLink;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingSocialMediaLinksTest extends TestCase
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
    public function it_gets_setting_social_media_links(): void
    {
        $setting = Setting::factory()->create();
        $socialMediaLinks = SocialMediaLink::factory()
            ->count(2)
            ->create([
                'setting_id' => $setting->id,
            ]);

        $response = $this->getJson(
            route('api.settings.social-media-links.index', $setting)
        );

        $response->assertOk()->assertSee($socialMediaLinks[0]->platform);
    }

    /**
     * @test
     */
    public function it_stores_the_setting_social_media_links(): void
    {
        $setting = Setting::factory()->create();
        $data = SocialMediaLink::factory()
            ->make([
                'setting_id' => $setting->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.settings.social-media-links.store', $setting),
            $data
        );

        unset($data['setting_id']);

        $this->assertDatabaseHas('social_media_links', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $socialMediaLink = SocialMediaLink::latest('id')->first();

        $this->assertEquals($setting->id, $socialMediaLink->setting_id);
    }
}
