<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContractsService;
use App\DataTransfer\Auth\LoginData;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Аутентификая пользователяы
     *
     * @param Request $request
     * @return JsonResource
     */
    public function __invoke(Request $request, AuthContractsService $authServices): JsonResource
    {
        // Проверка даных
        $isValid = Validator::make($request->toArray(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Если проверка не пройдена, то возвращаем ошибки
        if ($isValid->fails()){
            return JsonResource::make(['message' => $isValid->errors()]);
        }
        // Возвращаем результат
        return $authServices->login(LoginData::from($request));
    }
}
