<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\ReturnProdct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderReturnProdctsTest extends TestCase
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
    public function it_gets_order_return_prodcts(): void
    {
        $order = Order::factory()->create();
        $returnProdcts = ReturnProdct::factory()
            ->count(2)
            ->create([
                'order_id' => $order->id,
            ]);

        $response = $this->getJson(
            route('api.orders.return-prodcts.index', $order)
        );

        $response->assertOk()->assertSee($returnProdcts[0]->reason);
    }

    /**
     * @test
     */
    public function it_stores_the_order_return_prodcts(): void
    {
        $order = Order::factory()->create();
        $data = ReturnProdct::factory()
            ->make([
                'order_id' => $order->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.orders.return-prodcts.store', $order),
            $data
        );

        $this->assertDatabaseHas('return_prodcts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $returnProdct = ReturnProdct::latest('id')->first();

        $this->assertEquals($order->id, $returnProdct->order_id);
    }
}
