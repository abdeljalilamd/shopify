<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\EmailTemplate;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTemplateControllerTest extends TestCase
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
    public function it_displays_index_view_with_email_templates(): void
    {
        $emailTemplates = EmailTemplate::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('email-templates.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.email_templates.index')
            ->assertViewHas('emailTemplates');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_email_template(): void
    {
        $response = $this->get(route('email-templates.create'));

        $response->assertOk()->assertViewIs('app.email_templates.create');
    }

    /**
     * @test
     */
    public function it_stores_the_email_template(): void
    {
        $data = EmailTemplate::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('email-templates.store'), $data);

        $this->assertDatabaseHas('email_templates', $data);

        $emailTemplate = EmailTemplate::latest('id')->first();

        $response->assertRedirect(
            route('email-templates.edit', $emailTemplate)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_email_template(): void
    {
        $emailTemplate = EmailTemplate::factory()->create();

        $response = $this->get(route('email-templates.show', $emailTemplate));

        $response
            ->assertOk()
            ->assertViewIs('app.email_templates.show')
            ->assertViewHas('emailTemplate');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_email_template(): void
    {
        $emailTemplate = EmailTemplate::factory()->create();

        $response = $this->get(route('email-templates.edit', $emailTemplate));

        $response
            ->assertOk()
            ->assertViewIs('app.email_templates.edit')
            ->assertViewHas('emailTemplate');
    }

    /**
     * @test
     */
    public function it_updates_the_email_template(): void
    {
        $emailTemplate = EmailTemplate::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'subject' => $this->faker->text(255),
            'content' => $this->faker->text(),
        ];

        $response = $this->put(
            route('email-templates.update', $emailTemplate),
            $data
        );

        $data['id'] = $emailTemplate->id;

        $this->assertDatabaseHas('email_templates', $data);

        $response->assertRedirect(
            route('email-templates.edit', $emailTemplate)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_email_template(): void
    {
        $emailTemplate = EmailTemplate::factory()->create();

        $response = $this->delete(
            route('email-templates.destroy', $emailTemplate)
        );

        $response->assertRedirect(route('email-templates.index'));

        $this->assertModelMissing($emailTemplate);
    }
}
