<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ReturnProdct;

use App\Models\Order;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReturnProdctTest extends TestCase
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
    public function it_gets_return_prodcts_list(): void
    {
        $returnProdcts = ReturnProdct::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.return-prodcts.index'));

        $response->assertOk()->assertSee($returnProdcts[0]->reason);
    }

    /**
     * @test
     */
    public function it_stores_the_return_prodct(): void
    {
        $data = ReturnProdct::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.return-prodcts.store'), $data);

        $this->assertDatabaseHas('return_prodcts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.return-prodcts.update', $returnProdct),
            $data
        );

        $data['id'] = $returnProdct->id;

        $this->assertDatabaseHas('return_prodcts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_return_prodct(): void
    {
        $returnProdct = ReturnProdct::factory()->create();

        $response = $this->deleteJson(
            route('api.return-prodcts.destroy', $returnProdct)
        );

        $this->assertModelMissing($returnProdct);

        $response->assertNoContent();
    }
}
