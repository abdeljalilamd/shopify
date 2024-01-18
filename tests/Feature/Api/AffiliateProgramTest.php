<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AffiliateProgram;

use App\Models\Customer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliateProgramTest extends TestCase
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
    public function it_gets_affiliate_programs_list(): void
    {
        $affiliatePrograms = AffiliateProgram::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.affiliate-programs.index'));

        $response->assertOk()->assertSee($affiliatePrograms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_affiliate_program(): void
    {
        $data = AffiliateProgram::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.affiliate-programs.store'),
            $data
        );

        $this->assertDatabaseHas('affiliate_programs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.affiliate-programs.update', $affiliateProgram),
            $data
        );

        $data['id'] = $affiliateProgram->id;

        $this->assertDatabaseHas('affiliate_programs', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_affiliate_program(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();

        $response = $this->deleteJson(
            route('api.affiliate-programs.destroy', $affiliateProgram)
        );

        $this->assertSoftDeleted($affiliateProgram);

        $response->assertNoContent();
    }
}
