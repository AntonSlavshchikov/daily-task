<?php

namespace App\DataTransfer\User;

use Spatie\LaravelData\Data;

class CreateData extends Data
{
public function __construct(
    public string $name,
    public string $email,
    public string $password
)
{
}
}
