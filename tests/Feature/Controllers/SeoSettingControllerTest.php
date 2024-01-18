<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SeoSetting;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeoSettingControllerTest extends TestCase
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
    public function it_displays_index_view_with_seo_settings(): void
    {
        $seoSettings = SeoSetting::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('seo-settings.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.seo_settings.index')
            ->assertViewHas('seoSettings');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_seo_setting(): void
    {
        $response = $this->get(route('seo-settings.create'));

        $response->assertOk()->assertViewIs('app.seo_settings.create');
    }

    /**
     * @test
     */
    public function it_stores_the_seo_setting(): void
    {
        $data = SeoSetting::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('seo-settings.store'), $data);

        $this->assertDatabaseHas('seo_settings', $data);

        $seoSetting = SeoSetting::latest('id')->first();

        $response->assertRedirect(route('seo-settings.edit', $seoSetting));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_seo_setting(): void
    {
        $seoSetting = SeoSetting::factory()->create();

        $response = $this->get(route('seo-settings.show', $seoSetting));

        $response
            ->assertOk()
            ->assertViewIs('app.seo_settings.show')
            ->assertViewHas('seoSetting');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_seo_setting(): void
    {
        $seoSetting = SeoSetting::factory()->create();

        $response = $this->get(route('seo-settings.edit', $seoSetting));

        $response
            ->assertOk()
            ->assertViewIs('app.seo_settings.edit')
            ->assertViewHas('seoSetting');
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

        $response = $this->put(
            route('seo-settings.update', $seoSetting),
            $data
        );

        $data['id'] = $seoSetting->id;

        $this->assertDatabaseHas('seo_settings', $data);

        $response->assertRedirect(route('seo-settings.edit', $seoSetting));
    }

    /**
     * @test
     */
    public function it_deletes_the_seo_setting(): void
    {
        $seoSetting = SeoSetting::factory()->create();

        $response = $this->delete(route('seo-settings.destroy', $seoSetting));

        $response->assertRedirect(route('seo-settings.index'));

        $this->assertModelMissing($seoSetting);
    }
}
