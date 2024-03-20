<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
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

        return response()->json([
            'message' => 'Kullanıcıya ait kayıt bulundu!',
            'data' => [
                'register_status' => true
            ],
        ]);
    }

    public function authenticate(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Giriş Başarılı',
            'data' => [
                'token' => $token,
                'user' => $user
            ],
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::where('email', $request->email)->first();
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

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Kayıt Başarılı',
            'data' => [
                'token' => $token,
                'user' => $user
            ],
        ]);
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
        return response()->json([
            'message' => 'Profil güncellendi',
            'data' => [
                'user' => $user
            ]
        ]);
    }
}
