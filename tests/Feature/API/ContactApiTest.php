<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Contact;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_and_show_a_contact()
    {
        $response = $this->postJson('/api/contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'mobile' => '1234567890',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['id', 'first_name']]);

        $contactId = $response['data']['id'];

        $show = $this->getJson('/api/contacts/'.$contactId);
        $show->assertOk()
             ->assertJsonPath('data.id', $contactId);
    }
}
