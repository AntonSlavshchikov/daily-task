<?php

namespace Database\Factories;

use App\Models\CategoryTask;
use App\Models\User;
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
        $user = User::first();

        return [
            'title' => $this->faker->unique()->text(100),
            'category_id' => $category->id,
            'isReady' => false,
            'user_id' => $user->id
        ];
    }
}
