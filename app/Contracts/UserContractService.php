<?php

namespace App\Contracts;

use App\DataTransfer\User\CreateData;
use App\Models\User;

interface UserContractService {
    // Создать пользователя
    public function create(CreateData $data): User;
}
