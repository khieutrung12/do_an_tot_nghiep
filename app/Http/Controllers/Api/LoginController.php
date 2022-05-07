<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

class LoginController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);
            $user = $this->userRepo->findByAttributes(['email' => $request->email])->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => __('messages.login-fail'),
                ], 404);
            }
            $token = $user->createToken('accessToken')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => __('messages.logout-success'),
        ], 200);
    }
}
