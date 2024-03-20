<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function checkUser(CheckUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Kullanıcıya ait kayıt bulunamadı!',
                'data' => [
                    'register_status' => false
                ],
            ], 404);
        }

        return UserResource::make($user);
    }

    public function authenticate(LoginRequest $request)
    {
        $user = $this->getUserForEmail($request->email);
        if (!$user) {
            return response()->json([
                'message' => 'Kullanıcıya ait kayıt bulunamadı!',
                'data' => [],
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Parola hatalı',
                'data' => [],
            ], 401);
        }

        return UserResource::make($user);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->getUserForEmail($request->email);
        if ($user) {
            return response()->json([
                'message' => 'Kullanıcıya ait kayıt bulundu!',
                'data' => [
                    'register_status' => true
                ],
            ], 409);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return UserResource::make($user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = User::find(auth('sanctum')->user()->id);
        if (!$user) {
            return response()->json([
                'message' => 'Kullanıcıya ait kayıt bulunamadı!',
                'data' => [],
            ], 404);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return UserResource::make($user);
    }

    public function getUserForEmail($email)
    {
        return User::query()->where('email', $email)->first();
    }
}
