<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResource
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('auth_token');
            return JsonResource::make(['status' => 200, 'token' => $token->plainTextToken]);
        }

        return JsonResource::make(['status' => 401, 'error' => 'Unauthorised']);
    }
}
