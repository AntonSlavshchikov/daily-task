<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function __invoke(Request $request): UserResource|JsonResource
    {
        // Проверка данных
        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        try {
            // Начало транзакции
            DB::beginTransaction();
            // Создаем пользователя
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            // Создаем токен доступа
            $token = $user->createToken('auth_token');
            // Коммит транзакции
            DB::commit();
            // Возвращаем токен
            return JsonResource::make([
                'status' => 200,
                'token' => $token->plainTextToken
            ]);
        } catch (\Exception $e) {
            // Откатываем транзакцию
            DB::rollBack();
            // Пишем логи
            Log::error($e->getMessage());
            // Возвращаем ошибку
            return JsonResource::make(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
