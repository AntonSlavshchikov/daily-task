<?php

namespace App\Contracts;

interface TaskContractsService {
    // Создать задачу
    public function create();
    // Получить задачи пользователя
    public function getAllTaskUser();
}
