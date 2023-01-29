<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CategoryTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Создание тестового пользователя
        User::factory()->create();

        // Массив значений типа категории задач
        $category_type = ['Fundamentals', 'String', 'Algorithms', 'Mathematic', 'Performance', 'Booleans', 'Functions'];

        // Создание категорий задач
        foreach ($category_type as $item){
            CategoryTask::factory()->create([
                'title' => $item
            ]);
        }

        // Создание Задач
        Task::factory()->count(10)->create();
    }
}
