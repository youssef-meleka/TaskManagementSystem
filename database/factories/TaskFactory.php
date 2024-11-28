<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => Str::random(10), // Random string for title
            'description' => $this->faker->text(50), // Random text for description
            'completed' => $this->faker->boolean, // Random completed state
            'due_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)), // Random due date within the next 30 days
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']), // Random priority
            'category_id' => Category::inRandomOrder()->first()->id, // Random category ID
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
