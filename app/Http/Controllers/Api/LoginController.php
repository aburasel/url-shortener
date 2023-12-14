<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Traits\ResponseAPI;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use ResponseAPI;

    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::create($validated);
            return $this->success('Successfully Registered', ['user' => $user], Response::HTTP_OK);
        } catch (Exception $e) {
            $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();
        $credentials = ['email' => $validated['email'], 'password' => $validated['password']];
        try {
            if (!Auth::attempt($credentials)) {
                $this->error('Unauthorized, invalid email or password', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::where('email', $validated['email'])->first();
            $token = $request->user()->createToken('mobile-token')->plainTextToken;
            return $this->success('Login successful', ['token' => $token, 'token_type' => 'Bearer', 'user' => $user], Response::HTTP_OK);

        } catch (Exception $e) {
            $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}