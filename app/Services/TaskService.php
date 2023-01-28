<?php

namespace App\Services;

use App\Contracts\TaskContractsService;
use App\Http\Resources\TaskResource;
use App\Models\CategoryTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskService implements TaskContractsService
{
    public function create()
    {
        // Получаем всех пользователей
        $users = User::all();
        // Инициализация коллекции задач
        $collectionTask = collect();
        try {
            // Проходим по каждому из пользователей
            foreach ($users as $user) {
                // Опряделяем количество задач для пользователя
                $col_task = rand(1, 100);
                // Цикл для формирования задач заданного количества
                for ($i = 0; $i < $col_task; $i++) {
                    // Получаем рандомную категорию задачи
                    $category = collect(CategoryTask::get())->random();
                    // Добавляем задачу в коллекцию
                    $collectionTask->push([
                        'title' => fake()->text(100),
                        'category_id' => $category->id,
                        'user_id' => $user->id,
                    ]);
                }
                // Открываем транзакцию
                DB::beginTransaction();
                // Берем из коллекции только уникальные наименования и добавляем их в бд
                $collectionTask->unique('title')->map(function ($collect) {
                    Task::create($collect);
                });
                // Коммит транзакции
                DB::commit();
            }
        } catch (\Exception $e) {
            // Откат транзакции
            DB::rollBack();
            // Пишем логи
            Log::error($e->getMessage());
        }
    }

    public function getAllTaskUser(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|JsonResource
    {
        try {
            $nowDate = date('Y-m-d');
            // Получаем список задач для орпеделенного пользователя
            $tasks = Task::where('user_id', auth()->id())->where('created_at', 'LIKE', "$nowDate%")->get();
            // Возвращаем коллекцию задач
            return TaskResource::collection($tasks);
        } catch (\Exception $e) {
            // Пишем логи
            Log::error($e->getMessage());
            // Возвращаем ошибку
            return JsonResource::make([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
