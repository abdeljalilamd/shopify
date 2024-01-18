<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Discount;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountTest extends TestCase
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
    public function it_gets_discounts_list(): void
    {
        $discounts = Discount::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.discounts.index'));

        $response->assertOk()->assertSee($discounts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_discount(): void
    {
        $data = Discount::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.discounts.store'), $data);

        $this->assertDatabaseHas('discounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_discount(): void
    {
        $discount = Discount::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(2, 0, 9999),
            'coupon_code' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.discounts.update', $discount),
            $data
        );

        $data['id'] = $discount->id;

        $this->assertDatabaseHas('discounts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_discount(): void
    {
        $discount = Discount::factory()->create();

        $response = $this->deleteJson(
            route('api.discounts.destroy', $discount)
        );

        $this->assertModelMissing($discount);

        $response->assertNoContent();
    }
}
