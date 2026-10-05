<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{


    public function usersList()
    {
        $users = User::withCount('tasks')->get();
        return view("users.list", compact('users'));
    }

    public function create()
    {
        return view("users.create");
    }

    public function assignedTasks($id)
    {
        $user = User::with('tasks.attachments')->findOrFail($id);

        return view('users.assigned-tasks', compact('user'));
    }
}
