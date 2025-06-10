<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contact;
use App\Models\Order;

class ContactModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_a_contact(): void
    {
        $contact = Contact::factory()->create(['mobile' => '09123456789']);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'mobile' => '09123456789',
        ]);
    }

    public function test_it_has_many_orders_relationship(): void
    {
        $contact = Contact::factory()->create();
        $order = Order::factory()->create(['contact_id' => $contact->id]);

        $this->assertTrue($contact->orders->contains($order));
    }
}
