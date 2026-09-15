<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    
    
    public function usersList(){
        $users =User::all();
        return view("users.list", compact('users'));
    }

    public function create(){
        return view("users.create");
    }
}
