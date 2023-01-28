<?php

namespace App\DataTransfer\Auth;

use Spatie\LaravelData\Data;

class RegistrationData extends Data {
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {}
}
