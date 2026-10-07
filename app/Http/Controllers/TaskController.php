<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssignedMail;
use App\Models\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    
    
    public function edit($id)
    {
        $task = Task::find($id);
        $users = \App\Models\User::orderby('name')->get();
        return view('tasks.edit', compact('task', 'users'));
    }

    public function sendAssignmentEmail($id)
    {
        $task = Task::find($id);

        if (!$task || !$task->user) {
            return back()->with('error', 'This task has no assigned user to email.');
        }

         Mail::send('emails.task-assigned', compact('task') , function ($message) use ($task)  {
                $message
                    ->subject('New Task Assignment ')
                    ->to($task->user->email);
            });

            return back();
        //return back()->with('success', 'Task assignment email sent to ' . $task->user->name . '.');
    }
}
