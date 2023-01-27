<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetByIDController extends Controller
{
    /**
     * @param Request $request
     * @return TaskResource|JsonResource
     */
    public function __invoke(Request $request): TaskResource|JsonResource
    {
        // Поиск записи по ID
        try {
            // Начало транзакции
            DB::beginTransaction();
            // Получить задачу по id
            $task = Task::find($request->id);
            // Коммит транзакции
            DB::commit();
            // Если задача есть, то возвращаем ее
            if($task){
                return TaskResource::make($task);
            }
            // Если нет задачи, то возвращаем пустой массив
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
