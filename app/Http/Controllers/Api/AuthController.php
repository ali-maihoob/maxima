<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());
        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials does not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->currentAccessToken();
        if (!$token) {
            $token = $user->createToken('api_token');
        }
        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createtoken('test')->plainTextToken
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->success([
            'message' => 'Logged Out Successfully'
        ]);
    }
}
