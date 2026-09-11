<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function taskList(){
        $tasks = Task::all();
        return view('tasks.list', compact('tasks'));
        }
        
        public function show($id){
            $task = Task::find($id);
            return view('tasks.details', compact('task'));
    }
}
