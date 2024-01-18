<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\AffiliateProgram;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerAffiliateProgramsTest extends TestCase
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
    public function it_gets_customer_affiliate_programs(): void
    {
        $customer = Customer::factory()->create();
        $affiliatePrograms = AffiliateProgram::factory()
            ->count(2)
            ->create([
                'referral_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.affiliate-programs.index', $customer)
        );

        $response->assertOk()->assertSee($affiliatePrograms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_affiliate_programs(): void
    {
        $customer = Customer::factory()->create();
        $data = AffiliateProgram::factory()
            ->make([
                'referral_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.affiliate-programs.store', $customer),
            $data
        );

        $this->assertDatabaseHas('affiliate_programs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $affiliateProgram = AffiliateProgram::latest('id')->first();

        $this->assertEquals($customer->id, $affiliateProgram->referral_id);
    }
}
