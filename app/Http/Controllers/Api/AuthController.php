<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8'
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
            ], 201);
        } catch (Exception $e) {
            Log::error('Error occurred during registration: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
