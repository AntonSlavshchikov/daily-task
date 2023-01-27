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
        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $token = $user->createToken('auth_token');

            DB::commit();

            return JsonResource::make([
                'status' => 200,
                'token' => $token->plainTextToken
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return JsonResource::make(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
