<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SeoMeta;
use App\Models\SeoSetting;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeoSettingSeoMetasTest extends TestCase
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
    public function it_gets_seo_setting_seo_metas(): void
    {
        $seoSetting = SeoSetting::factory()->create();
        $seoMetas = SeoMeta::factory()
            ->count(2)
            ->create([
                'seo_setting_id' => $seoSetting->id,
            ]);

        $response = $this->getJson(
            route('api.seo-settings.seo-metas.index', $seoSetting)
        );

        $response->assertOk()->assertSee($seoMetas[0]->type);
    }

    /**
     * @test
     */
    public function it_stores_the_seo_setting_seo_metas(): void
    {
        $seoSetting = SeoSetting::factory()->create();
        $data = SeoMeta::factory()
            ->make([
                'seo_setting_id' => $seoSetting->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.seo-settings.seo-metas.store', $seoSetting),
            $data
        );

        unset($data['seo_setting_id']);

        $this->assertDatabaseHas('seo_metas', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $seoMeta = SeoMeta::latest('id')->first();

        $this->assertEquals($seoSetting->id, $seoMeta->seo_setting_id);
    }
}
