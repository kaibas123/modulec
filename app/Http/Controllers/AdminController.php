<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
//    function for view admin list page
    public function admins()
    {
        return view("admins");
    }
}
