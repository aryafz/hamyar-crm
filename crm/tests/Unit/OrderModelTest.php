<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Project;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_an_order(): void
    {
        $order = Order::factory()->create();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'contact_id' => $order->contact_id,
        ]);
    }

    public function test_it_belongs_to_contact(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(Contact::class, $order->contact);
    }

    public function test_it_has_many_projects(): void
    {
        $order = Order::factory()->create();
        $project = Project::factory()->create(['order_id' => $order->id]);

        $this->assertTrue($order->projects->contains($project));
    }
}
