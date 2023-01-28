<?php

namespace App\Services;

use App\Contracts\UserContractService;
use App\DataTransfer\User\CreateData;
use App\Models\User;

class UserService implements UserContractService
{
    public function create(CreateData $data): User
    {
        /*
         * Объединяем массив с двумя одинаковыми ключами.
         * Так как приходит массив с "открытым паролем", нужно его зашифровать
         * Используем функцию array_merge которая объединяет два массива с одинаковыми ключами
         * в нашем случае это поле "password"
         */
        $data = array_merge($data->toArray(), [
            'password' => bcrypt($data->password)
        ]);
        // Создаем пользователя и возвращаем его
        return User::create($data);
    }
}
