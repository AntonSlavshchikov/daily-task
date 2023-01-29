<?php

namespace App\Http\Controllers\Task;

use App\Contracts\TaskContractsService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class UpdateController extends Controller
{
    /**
     * Обновить залачу (Отметить как выполненная задача)
     *
     * @param Request $request
     * @return TaskResource|JsonResource
     */
    public function __invoke(Request $request, TaskContractsService $taskService): TaskResource|JsonResource
    {
        return $taskService->updateTask($request->id);
    }
}
