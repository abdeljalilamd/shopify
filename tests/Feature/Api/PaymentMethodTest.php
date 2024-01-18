<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentMethod;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodTest extends TestCase
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
    public function it_gets_payment_methods_list(): void
    {
        $paymentMethods = PaymentMethod::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.payment-methods.index'));

        $response->assertOk()->assertSee($paymentMethods[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_method(): void
    {
        $data = PaymentMethod::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.payment-methods.store'), $data);

        $this->assertDatabaseHas('payment_methods', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_payment_method(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->putJson(
            route('api.payment-methods.update', $paymentMethod),
            $data
        );

        $data['id'] = $paymentMethod->id;

        $this->assertDatabaseHas('payment_methods', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_payment_method(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->deleteJson(
            route('api.payment-methods.destroy', $paymentMethod)
        );

        $this->assertModelMissing($paymentMethod);

        $response->assertNoContent();
    }
}
