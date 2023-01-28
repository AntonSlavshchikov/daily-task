<?php

namespace App\Http\Controllers\Task;

use App\Contracts\TaskContractsService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\CategoryTask;
use App\Models\Task;
use App\Models\User;
use \Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    // Создать список задач для пользователей
    public function __invoke(TaskContractsService $taskService): void
    {
        $taskService->create();
    }
}
