<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EmailTemplate;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTemplateTest extends TestCase
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
    public function it_gets_email_templates_list(): void
    {
        $emailTemplates = EmailTemplate::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.email-templates.index'));

        $response->assertOk()->assertSee($emailTemplates[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_email_template(): void
    {
        $data = EmailTemplate::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.email-templates.store'), $data);

        $this->assertDatabaseHas('email_templates', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.email-templates.update', $emailTemplate),
            $data
        );

        $data['id'] = $emailTemplate->id;

        $this->assertDatabaseHas('email_templates', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_email_template(): void
    {
        $emailTemplate = EmailTemplate::factory()->create();

        $response = $this->deleteJson(
            route('api.email-templates.destroy', $emailTemplate)
        );

        $this->assertModelMissing($emailTemplate);

        $response->assertNoContent();
    }
}
