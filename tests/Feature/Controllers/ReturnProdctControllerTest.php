<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ReturnProdct;

use App\Models\Order;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReturnProdctControllerTest extends TestCase
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
    public function it_displays_index_view_with_return_prodcts(): void
    {
        $returnProdcts = ReturnProdct::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('return-prodcts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.return_prodcts.index')
            ->assertViewHas('returnProdcts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_return_prodct(): void
    {
        $response = $this->get(route('return-prodcts.create'));

        $response->assertOk()->assertViewIs('app.return_prodcts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_return_prodct(): void
    {
        $data = ReturnProdct::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('return-prodcts.store'), $data);

        $this->assertDatabaseHas('return_prodcts', $data);

        $returnProdct = ReturnProdct::latest('id')->first();

        $response->assertRedirect(route('return-prodcts.edit', $returnProdct));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_return_prodct(): void
    {
        $returnProdct = ReturnProdct::factory()->create();

        $response = $this->get(route('return-prodcts.show', $returnProdct));

        $response
            ->assertOk()
            ->assertViewIs('app.return_prodcts.show')
            ->assertViewHas('returnProdct');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_return_prodct(): void
    {
        $returnProdct = ReturnProdct::factory()->create();

        $response = $this->get(route('return-prodcts.edit', $returnProdct));

        $response
            ->assertOk()
            ->assertViewIs('app.return_prodcts.edit')
            ->assertViewHas('returnProdct');
    }

    /**
     * @test
     */
    public function it_updates_the_return_prodct(): void
    {
        $returnProdct = ReturnProdct::factory()->create();

        $order = Order::factory()->create();

        $data = [
            'reason' => $this->faker->text(),
            'order_id' => $order->id,
        ];

        $response = $this->put(
            route('return-prodcts.update', $returnProdct),
            $data
        );

        $data['id'] = $returnProdct->id;

        $this->assertDatabaseHas('return_prodcts', $data);

        $response->assertRedirect(route('return-prodcts.edit', $returnProdct));
    }

    /**
     * @test
     */
    public function it_deletes_the_return_prodct(): void
    {
        $returnProdct = ReturnProdct::factory()->create();

        $response = $this->delete(
            route('return-prodcts.destroy', $returnProdct)
        );

        $response->assertRedirect(route('return-prodcts.index'));

        $this->assertModelMissing($returnProdct);
    }
}
