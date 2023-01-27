<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    /**
     * @param Request $request
     * @return TaskResource|JsonResource
     */
    public function __invoke(Request $request): TaskResource|JsonResource
    {
        // Обновление записи
        try {
            // Начало транзакции
            DB::beginTransaction();
            // Поиск по ID и обновление записи
            $task = Task::find($request->id);
            // Проверка есть ли ЗАДАЧА
            if($task){
                // Помечаем как выполненную
                $task->update([
                    'isReady' => $request->isReady
                ]);
                // Коммит транзакции
                DB::commit();
                // Возвращаем обновленную задачу
                return TaskResource::make($task);
            }
            // Коммит транзакции
            DB::commit();
            // Возвращаем null если пусто
            return JsonResource::make(null);
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
