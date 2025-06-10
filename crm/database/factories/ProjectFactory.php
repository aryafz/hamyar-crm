<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Project, Order};

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'name' => $this->faker->word,
            'status' => 'pending',
            'description' => $this->faker->sentence,
        ];
    }
}
