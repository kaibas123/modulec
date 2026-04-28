<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users()
    {
        $users = User::withTrashed()->get();
        return view("users", compact("users"));
    }

    public function users_detail(User $user)
    {
        return view("user_detail", compact('user'));
    }

    public function block(Request $request, User $user)
    {
        $user->delete();
        $user->update([
            "blocked" => $request['reason']
        ]);

        return to_route("users")->with("msg", "User blocked.");
    }

    public function restore(User $user)
    {
        $user->restore();
        return to_route("users")->with("msg", "User restored.");
    }
}
