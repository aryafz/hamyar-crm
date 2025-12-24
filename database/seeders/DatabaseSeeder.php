<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ساخت ۱۰ تا مشتری الکی
        \App\Models\Contact::factory(10)->create();

        // ساخت ۲۰ تا سفارش الکی برای مشتری‌های مختلف
        \App\Models\Order::factory(20)->create();

        // ساخت ۵ تا پروژه و تسک
        \App\Models\Project::factory(5)->create();
        \App\Models\Task::factory(10)->create();
    }
}
