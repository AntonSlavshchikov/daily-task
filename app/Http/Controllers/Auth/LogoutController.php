<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\AuthContractsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogoutController extends Controller
{
    // Выход из системв
    public function __invoke(Request $request, AuthContractsService $authService): JsonResource
    {
        return $authService->logout();
    }
}
