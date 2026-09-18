<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function index(){
        $users = User::with('tasks')->get();

        return UserResource::collection($users);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|unique:users,email',
            'password'=> 'required|min:6'
        ]);

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        return response()->json(['message' => 'User created successfully']);
    }

    function show($id){
        $user = User::find($id);
        return UserResource::make($user);   
    }
}
