<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResource
     */
    public function __invoke(Request $request): JsonResource
    {
        // Массив данныз пользователя
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        // Проверка пользователя
        if (auth()->attempt($data)) {
            // Если данные верны то создаем токен
            $token = auth()->user()->createToken('auth_token');
            // Возвращаем токен
            return JsonResource::make(['status' => 200, 'token' => $token->plainTextToken]);
        }
        // Если данные не верны, то ошибка
        return JsonResource::make(['status' => 401, 'error' => 'Unauthorised']);
    }
}
