<?php

namespace App\Contracts;

use App\DataTransfer\Auth\LoginData;
use App\DataTransfer\Auth\RegistrationData;
use Illuminate\Http\Resources\Json\JsonResource;

interface AuthContractsService {
    // Подключение сервиса пользователей
    public function __construct(UserContractService $userContractService);
    // Регистрация пользователя
    public function registration(RegistrationData $registrationData): JsonResource;
    // Аутентификция
    public function login(LoginData $loginData): JsonResource;
}

