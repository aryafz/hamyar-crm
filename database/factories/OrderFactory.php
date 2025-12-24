<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Order, Contact};

class OrderFactory extends Factory
{
    protected $model = Order::class;

    // OrderFactory.php
    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory(),
            'type' => $this->faker->randomElement(['سرویس', 'محصول']), // فارسی کردیم
            'status' => $this->faker->randomElement(['new', 'pending', 'completed']),
            'amount' => $this->faker->numberBetween(100000, 5000000), // مبلغ بین ۱۰۰ هزار تا ۵ میلیون تومان
            'deposit' => 0,
        ];
    }
}
