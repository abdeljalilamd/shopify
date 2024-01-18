<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentMethod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodPaymentsTest extends TestCase
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
    public function it_gets_payment_method_payments(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();
        $payments = Payment::factory()
            ->count(2)
            ->create([
                'payment_method_id' => $paymentMethod->id,
            ]);

        $response = $this->getJson(
            route('api.payment-methods.payments.index', $paymentMethod)
        );

        $response->assertOk()->assertSee($payments[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_method_payments(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();
        $data = Payment::factory()
            ->make([
                'payment_method_id' => $paymentMethod->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-methods.payments.store', $paymentMethod),
            $data
        );

        $this->assertDatabaseHas('payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $payment = Payment::latest('id')->first();

        $this->assertEquals($paymentMethod->id, $payment->payment_method_id);
    }
}
