<?php

namespace App\Providers;

use App\Contracts\AuthContractsService;
use App\Contracts\TaskContractsService;
use App\Contracts\UserContractService;
use App\Services\AuthService;
use App\Services\TaskService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;


class ContractServiceProvider extends ServiceProvider {
    public array $bindings = [
        AuthContractsService::class => AuthService::class,
        UserContractService::class => UserService::class,
        TaskContractsService::class => TaskService::class
    ];
}
