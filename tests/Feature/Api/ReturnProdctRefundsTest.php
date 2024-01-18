<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Refund;
use App\Models\ReturnProdct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReturnProdctRefundsTest extends TestCase
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
    public function it_gets_return_prodct_refunds(): void
    {
        $returnProdct = ReturnProdct::factory()->create();
        $refunds = Refund::factory()
            ->count(2)
            ->create([
                'returnProdct_id' => $returnProdct->id,
            ]);

        $response = $this->getJson(
            route('api.return-prodcts.refunds.index', $returnProdct)
        );

        $response->assertOk()->assertSee($refunds[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_return_prodct_refunds(): void
    {
        $returnProdct = ReturnProdct::factory()->create();
        $data = Refund::factory()
            ->make([
                'returnProdct_id' => $returnProdct->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.return-prodcts.refunds.store', $returnProdct),
            $data
        );

        unset($data['returnProdct_id']);

        $this->assertDatabaseHas('refunds', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $refund = Refund::latest('id')->first();

        $this->assertEquals($returnProdct->id, $refund->returnProdct_id);
    }
}
