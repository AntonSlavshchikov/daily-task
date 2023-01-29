<?php

namespace App\Contracts;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\JsonResource;

interface TaskContractsService {
    // Создать задачу
    public function create(): void;
    // Получить задачи пользователя
    public function getAllTaskUser(): JsonResource | TaskResource;
    // Обновить задачу (отметить выполненной)
    public function updateTask(int $id): JsonResource | TaskResource;
    // Заменить задачу
    public function replaceTask(int $id): JsonResource | TaskResource;
}
