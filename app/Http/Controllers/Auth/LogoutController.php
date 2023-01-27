<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request): JsonResource
    {
        auth()->user()->token()->delete();
        return JsonResource::make(['status' => 200, 'message' => 'You are successfully logged out']);
    }
}
