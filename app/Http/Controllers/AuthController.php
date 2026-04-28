<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }

    public function login_action(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required"
        ]);

        if (Auth::attempt($request->only("username", "password"))) {
            $user = Admin::query()->find(auth()->id());
            $user->lastLogin = now();
            $user->save();

            return to_route("index")->with("msg", "Login success");
        } else {
            return back()->withErrors("Wrong username or password.");
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route("index")->with("msg", "Logout success");
    }
}
