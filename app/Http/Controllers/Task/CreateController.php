<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use \Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    /**
     * @param Request $request
     * @return TaskResource|JsonResource
     */
    public function __invoke(Request $request): TaskResource|JsonResource
    {
        // Проверка
        $request->validate([
            'title' => 'required'
        ]);
        // Действия если проверка пройдена
        try {
            // Начало транзакции
            DB::beginTransaction();
            // Создать запись
            $task = Task::create($request->toArray());
            // Коммит транзакции
            DB::commit();
            // Возвращаем созданную запись
            return TaskResource::make($task);
        } catch (\Exception $e) {
            // Откатываем транзакцию
            DB::rollBack();
            // Пишем логи
            Log::error($e->getMessage());
            // Возвращаем ошибку
            return JsonResource::make(['status' => 500,'error' => $e->getMessage()]);
        }
    }
}
