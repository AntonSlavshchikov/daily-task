<?php

namespace App\Services;

use App\Contracts\AuthContractsService;
use App\Contracts\UserContractService;
use App\DataTransfer\Auth\LoginData;
use App\DataTransfer\Auth\RegistrationData;
use App\DataTransfer\User\CreateData as UserData;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthContractsService
{
    public function __construct(protected UserContractService $userContractService)
    {
        //
    }

    /**
     * Регистрация пользователя
     *
     * @param RegistrationData $registrationData
     * @return JsonResource
     */
    // Регистрация пользователя
    public function registration(RegistrationData $registrationData): JsonResource
    {
        try {
            // Создаем пользователя
            DB::beginTransaction();
            $user = $this->userContractService->create(
                UserData::from(
                    $registrationData->only('name', 'email', 'password')
                )
            );
            // Генерируем токен
            $token = $user->createToken('auth_token');
            DB::commit();
            // Возвращаем результат
            return JsonResource::make(['token' => $token->plainTextToken], 200);
        } catch (\Exception $e) {
            // Откат транзакции
            DB::rollBack();
            // Пишем логи
            Log::error($e->getMessage());
            // Отправляем ошибкуы
            return JsonResource::make(['error' => $e->getMessage()]);
        }
    }

    /**
     * Аутентификация пользователя
     *
     * @param LoginData $loginData
     * @return JsonResource
     */
    public function login(LoginData $loginData): JsonResource
    {
        // Если пользователь авторизирован то генерируем токен и возвращаем его
        if (auth()->attempt($loginData->toArray())){
            $token = auth()->user()->createToken('auth_token');

            return JsonResource::make(['token' => $token->plainTextToken]);
        }
        // Ошибка в случае неудачи
        return JsonResource::make([
            'error' => 'Unautorize'
        ], 401);
    }
}

