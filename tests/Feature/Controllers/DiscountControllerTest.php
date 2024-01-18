<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Discount;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscountControllerTest extends TestCase
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
    public function it_displays_index_view_with_discounts(): void
    {
        $discounts = Discount::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('discounts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.discounts.index')
            ->assertViewHas('discounts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_discount(): void
    {
        $response = $this->get(route('discounts.create'));

        $response->assertOk()->assertViewIs('app.discounts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_discount(): void
    {
        $data = Discount::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('discounts.store'), $data);

        $this->assertDatabaseHas('discounts', $data);

        $discount = Discount::latest('id')->first();

        $response->assertRedirect(route('discounts.edit', $discount));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_discount(): void
    {
        $discount = Discount::factory()->create();

        $response = $this->get(route('discounts.show', $discount));

        $response
            ->assertOk()
            ->assertViewIs('app.discounts.show')
            ->assertViewHas('discount');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_discount(): void
    {
        $discount = Discount::factory()->create();

        $response = $this->get(route('discounts.edit', $discount));

        $response
            ->assertOk()
            ->assertViewIs('app.discounts.edit')
            ->assertViewHas('discount');
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

        $response = $this->put(route('discounts.update', $discount), $data);

        $data['id'] = $discount->id;

        $this->assertDatabaseHas('discounts', $data);

        $response->assertRedirect(route('discounts.edit', $discount));
    }

    /**
     * @test
     */
    public function it_deletes_the_discount(): void
    {
        $discount = Discount::factory()->create();

        $response = $this->delete(route('discounts.destroy', $discount));

        $response->assertRedirect(route('discounts.index'));

        $this->assertModelMissing($discount);
    }
}
