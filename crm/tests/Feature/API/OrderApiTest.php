<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{Contact, Order};

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_orders_with_projects_and_tasks()
    {
        $contact = Contact::factory()->create();
        $order = Order::factory()->create(['contact_id' => $contact->id]);

        $response = $this->getJson('/api/orders');

        $response->assertOk()
            ->assertJsonStructure(['data' => [['id', 'projects']]]);
    }
}
