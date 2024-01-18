<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AffiliateProgram;
use App\Models\AffiliateCommission;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliateProgramAffiliateCommissionsTest extends TestCase
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
    public function it_gets_affiliate_program_affiliate_commissions(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();
        $affiliateCommissions = AffiliateCommission::factory()
            ->count(2)
            ->create([
                'affiliate_program_id' => $affiliateProgram->id,
            ]);

        $response = $this->getJson(
            route(
                'api.affiliate-programs.affiliate-commissions.index',
                $affiliateProgram
            )
        );

        $response->assertOk()->assertSee($affiliateCommissions[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_affiliate_program_affiliate_commissions(): void
    {
        $affiliateProgram = AffiliateProgram::factory()->create();
        $data = AffiliateCommission::factory()
            ->make([
                'affiliate_program_id' => $affiliateProgram->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.affiliate-programs.affiliate-commissions.store',
                $affiliateProgram
            ),
            $data
        );

        unset($data['affiliate_program_id']);

        $this->assertDatabaseHas('affiliate_commissions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $affiliateCommission = AffiliateCommission::latest('id')->first();

        $this->assertEquals(
            $affiliateProgram->id,
            $affiliateCommission->affiliate_program_id
        );
    }
}
