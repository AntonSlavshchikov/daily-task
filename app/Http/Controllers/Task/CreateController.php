<?php

namespace App\Http\Controllers\Task;

use App\Contracts\TaskContractsService;
use App\Http\Controllers\Controller;


class CreateController extends Controller
{
    /**
     * Создать список задач для пользователей
     * @param TaskContractsService $taskService
     * @return void
     */
    public function __invoke(TaskContractsService $taskService): void
    {
        $taskService->create();
    }
}
