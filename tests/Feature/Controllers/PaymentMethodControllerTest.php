<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PaymentMethod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentMethodControllerTest extends TestCase
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
    public function it_displays_index_view_with_payment_methods(): void
    {
        $paymentMethods = PaymentMethod::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('payment-methods.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_methods.index')
            ->assertViewHas('paymentMethods');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_payment_method(): void
    {
        $response = $this->get(route('payment-methods.create'));

        $response->assertOk()->assertViewIs('app.payment_methods.create');
    }

    /**
     * @test
     */
    public function it_stores_the_payment_method(): void
    {
        $data = PaymentMethod::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('payment-methods.store'), $data);

        $this->assertDatabaseHas('payment_methods', $data);

        $paymentMethod = PaymentMethod::latest('id')->first();

        $response->assertRedirect(
            route('payment-methods.edit', $paymentMethod)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_payment_method(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->get(route('payment-methods.show', $paymentMethod));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_methods.show')
            ->assertViewHas('paymentMethod');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_payment_method(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->get(route('payment-methods.edit', $paymentMethod));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_methods.edit')
            ->assertViewHas('paymentMethod');
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

        $response = $this->put(
            route('payment-methods.update', $paymentMethod),
            $data
        );

        $data['id'] = $paymentMethod->id;

        $this->assertDatabaseHas('payment_methods', $data);

        $response->assertRedirect(
            route('payment-methods.edit', $paymentMethod)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_payment_method(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $response = $this->delete(
            route('payment-methods.destroy', $paymentMethod)
        );

        $response->assertRedirect(route('payment-methods.index'));

        $this->assertModelMissing($paymentMethod);
    }
}
