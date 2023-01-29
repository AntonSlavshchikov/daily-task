<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContractsService;
use App\DataTransfer\Auth\RegistrationData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Регистрация пользователя
     *
     * @param Request $request
     * @param AuthContractsService $authService
     * @return JsonResource
     */
    public function __invoke(Request $request, AuthContractsService $authService): JsonResource
    {
        // Проверка данных
        $isValid = Validator::make($request->toArray(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        // Если проверка не пройдена
        if ($isValid->fails()) {
            return JsonResource::make([
                'message' => $isValid->errors()
            ]);
        }

        // Регистрация
        return $authService->registration(
            RegistrationData::from($request)
        );
    }
}
