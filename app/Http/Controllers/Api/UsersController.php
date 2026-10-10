<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function index(Request $request){
        $query = User::withCount('tasks');

        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $name = trim((string) $request->query('name', ''));
        if ($name !== '') {
            $query->where('name', 'like', "%{$name}%");
        }

        $email = trim((string) $request->query('email', ''));
        if ($email !== '') {
            $query->where('email', 'like', "%{$email}%");
        }

        $users = $query->get();

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
