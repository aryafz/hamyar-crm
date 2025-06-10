<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_show_customer(): void
    {
        $response = $this->postJson('/api/contacts', [
            'first_name' => 'Ali',
            'last_name' => 'Rezaei',
            'mobile' => '09111234567',
        ]);

        $response->assertCreated()
                 ->assertJsonStructure(['data' => ['id', 'first_name']]);

        $id = $response['data']['id'];

        $show = $this->getJson('/api/contacts/' . $id);
        $show->assertOk()
             ->assertJsonPath('data.id', $id)
             ->assertJsonPath('data.mobile', '09111234567');
    }
}
