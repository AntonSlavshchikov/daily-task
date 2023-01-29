<?php

namespace App\Http\Controllers\Task;

use App\Contracts\TaskContractsService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllUserTaskController extends Controller
{
    /**
     * Получить список задач для определенного пользователя на день
     *
     * @param TaskContractsService $taskService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(TaskContractsService $taskService): TaskResource|JsonResource
    {
        return $taskService->GetAllTaskUser();
    }
}
