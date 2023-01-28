<?php

namespace App\Http\Controllers\Task;

use App\Contracts\TaskContractsService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class GetAllUserTaskController extends Controller
{
    /**
     * ПОлучить список задач для определенного пользователя на день
     *
     * @param TaskContractsService $taskService
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(TaskContractsService $taskService): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $taskService->GetAllTaskUser();
    }
}
