<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class AuthenticationController extends Controller
{
    //
    public function register(Request $request) {
        $register_data = $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'role' => 'required|in:admin,customer',
            'contact_number' => 'required|string',
            'password' => 'required|min:8',
        ]);
    
        try {
            $user = User::create([
                'username' => $register_data['username'],
                'email' => $register_data['email'],
                'role' => $register_data['role'],
                'contact_number' => $register_data['contact_number'],
                'password' => Hash::make($register_data['password']),
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error creating user',
            ], 500);
        }
    
        return response()->json([
            'message'=> 'User created',
        ], 200); // Ensure you return a 200 status code on success
    }

    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $loginUserData['email'])->first();
        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name . '-AuthToken', ['*'], Carbon::now()->addHour(1))->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'role' => $user->role,
            'userId' => $user->id,
            'message' => 'You are logged in',
        ]);

        
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "Logged out"
        ]);
    }

}
