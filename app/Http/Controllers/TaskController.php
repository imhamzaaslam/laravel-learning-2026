<?php

namespace App\Http\Controllers;

use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function taskList()
    {


        return view('tasks.list');
    }

    public function create()
    {
        $users = \App\Models\User::orderby('name')->get();
        return view('tasks.create', compact('users'));
    }

    public function show($id)
    {
        $task = Task::find($id);
        return view('tasks.details', compact('task'));
    }
}
