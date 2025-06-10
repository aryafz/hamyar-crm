<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Order, Contact};

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'type' => $this->faker->randomElement(['service', 'product']),
            'status' => 'new',
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'deposit' => 0,
        ];
    }
}
