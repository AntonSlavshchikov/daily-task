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
    /**
     * Создание задач для каждого из пользователей
     *
     * @return void
     */
    public function create(): void
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

    /**
     * Получение задач для определенного пользователя
     *
     * @return TaskResource|JsonResource
     */
    public function getAllTaskUser(): TaskResource|JsonResource
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

    /**
     * Обновить задачу пользователя по ID (Отметить выполненной)
     *
     * @param int $id
     * @return TaskResource|JsonResource
     */
    public function updateTask(int $id): TaskResource|JsonResource
    {
        // Обновление записи
        try {
            // Начало транзакции
            DB::beginTransaction();
            // Поиск по ID и обновление записи
            $task = Task::find($id);
            // Если задачи нет, то вовзращаем сообщение
            if (!$task) {
                DB::commit();
                // Возвращаем null если пусто
                return JsonResource::make(['message' => 'Task not'], 400);
            }
            // Помечаем как выполненную
            $task->update([
                'isReady' => true
            ]);
            // Коммит транзакции
            DB::commit();
            // Возвращаем обновленную задачу
            return TaskResource::make($task);
        } catch (\Exception $e) {
            // Откатываем транзакцию
            DB::rollBack();
            // Пишем логи
            Log::error($e->getMessage());
            // Возвращаем ошибку
            return JsonResource::make(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Замена задачи
     *
     * @param int $id
     * @return TaskResource|JsonResource
     */
    public function replaceTask(int $id): TaskResource|JsonResource
    {
        // Обновление записи
        try {
            // Начало транзакции
            DB::beginTransaction();
            // Поиск по ID и обновление записи
            $task = Task::find($id);
            // Проверка есть ли ЗАДАЧА
            if (!$task) {
                // Коммит транзакции
                DB::commit();
                // Возвращаем null если пусто
                return JsonResource::make(['message' => 'Task not']);
            }
            // Получаем рандомую категорию задачи
            $category_task = collect(CategoryTask::get())->random();
            // Заменяем задачу
            $task->update([
                'title' => \Illuminate\Support\Str::random(100),
                'category_id' => $category_task->id,
                'isReady' => false
            ]);
            // Коммит транзакции
            DB::commit();
            // Возвращаем обновленную задачу
            return TaskResource::make($task);
        } catch (\Exception $e) {
            // Откатываем транзакцию
            DB::rollBack();
            // Пишем логи
            Log::error($e->getMessage());
            // Возвращаем ошибку
            return JsonResource::make(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
