<?php

namespace Database\Factories;

use App\Models\CategoryTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = collect(CategoryTask::get())->random();

        return [
            'title' => $this->faker->title,
            'category_id' => $category->id,
            'isReady' => false
        ];
    }
}
