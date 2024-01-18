<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderPaymentsTest extends TestCase
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
    public function it_gets_order_payments(): void
    {
        $order = Order::factory()->create();
        $payments = Payment::factory()
            ->count(2)
            ->create([
                'order_id' => $order->id,
            ]);

        $response = $this->getJson(route('api.orders.payments.index', $order));

        $response->assertOk()->assertSee($payments[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_order_payments(): void
    {
        $order = Order::factory()->create();
        $data = Payment::factory()
            ->make([
                'order_id' => $order->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.orders.payments.store', $order),
            $data
        );

        $this->assertDatabaseHas('payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $payment = Payment::latest('id')->first();

        $this->assertEquals($order->id, $payment->order_id);
    }
}
