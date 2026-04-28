<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function signup(Request $request)
    {
        $val = $request->validate([
            "username" => "required|unique:users,username|min:4|max:60",
            "password" => "required|min:8|max:32",
        ]);

        $user = User::query()->create([
            "username" => $request->username,
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => "success",
            "token" => $user->createToken("api")->plainTextToken
        ], 201);
    }

    function signin(Request $request)
    {
        $request->validate([
            "username" => "required|min:4|max:60",
            "password" => "required|min:8|max:32",
        ]);

        $user = User::withTrashed()->where("username", $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => "invalid",
                "message" => "Wrong username or password",
            ], 401);
        }

        if ($user->trashed()) {
            return response()->json([
                "status" => "blocked",
                "message" => "User blocked",
                "reason" => $user->blocked
            ], 403);
        }

        return response()->json([
            "status" => "success",
            "token" => $user->createToken("api")->plainTextToken
        ]);
    }

    public function signout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => "success"
        ]);
    }
}
