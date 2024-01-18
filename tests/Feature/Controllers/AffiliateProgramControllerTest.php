<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\AffiliateProgram;

use App\Models\Customer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliateProgramControllerTest extends TestCase
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
    public function it_displays_index_view_with_affiliate_programs(): void
    {
        $affiliatePrograms = AffiliateProgram::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('affiliate-programs.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.affiliate_programs.index')
            ->assertViewHas('affiliatePrograms');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_affiliate_program(): void
    {
        $response = $this->get(route('affiliate-programs.create'));

        $response->assertOk()->assertViewIs('app.affiliate_programs.create');
    }

    /**
     * @test
     */
    public function it_stores_the_affiliate_program(): void
    {
        $data = AffiliateProgram::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('affiliate-programs.store'), $data);

        $this->assertDatabaseHas('affiliate_programs', $data);

        $affiliateProgram = AffiliateProgram::latest('id')->first();

        $response->assertRedirect(
            route('affiliate-programs.edit', $affiliateProgram)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_affiliate_program(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();

        $response = $this->get(
            route('affiliate-programs.show', $affiliateProgram)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.affiliate_programs.show')
            ->assertViewHas('affiliateProgram');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_affiliate_program(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();

        $response = $this->get(
            route('affiliate-programs.edit', $affiliateProgram)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.affiliate_programs.edit')
            ->assertViewHas('affiliateProgram');
    }

    /**
     * @test
     */
    public function it_updates_the_affiliate_program(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();

        $customer = Customer::factory()->create();
        $customer = Customer::factory()->create();

        $data = [
            'commission' => $this->faker->randomFloat(2, 0, 9999),
            'affiliate_id' => $customer->id,
            'referral_id' => $customer->id,
        ];

        $response = $this->put(
            route('affiliate-programs.update', $affiliateProgram),
            $data
        );

        $data['id'] = $affiliateProgram->id;

        $this->assertDatabaseHas('affiliate_programs', $data);

        $response->assertRedirect(
            route('affiliate-programs.edit', $affiliateProgram)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_affiliate_program(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();

        $response = $this->delete(
            route('affiliate-programs.destroy', $affiliateProgram)
        );

        $response->assertRedirect(route('affiliate-programs.index'));

        $this->assertSoftDeleted($affiliateProgram);
    }
}
