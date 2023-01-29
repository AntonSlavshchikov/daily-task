<?php

namespace App\DataTransfer\Auth;

use Spatie\LaravelData\Data;

// Данные для регистрации польщователя
class RegistrationData extends Data {
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {}
}
