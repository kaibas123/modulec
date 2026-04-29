<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
//    function for view user list page
    public function users()
    {
        $users = User::withTrashed()->get();
        return view("users", compact("users"));
    }

//    function for view separate user page
    public function users_detail(User $user)
    {
        return view("user_detail", compact('user'));
    }

//    function for block user
    public function block(Request $request, User $user)
    {
        $user->delete();
        $user->update([
            "blocked" => $request['reason']
        ]);

        return to_route("users")->with("msg", "User blocked.");
    }

//    function for unblock user
    public function restore(User $user)
    {
        $user->restore();
        return to_route("users")->with("msg", "User restored.");
    }
}
