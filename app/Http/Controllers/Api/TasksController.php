<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function index(){
        $tasks = Task::with('user')->get();
        return response()->json($tasks);
    }

    public function store(Request $request){

        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'estimated_time' => 'nullable|string|max:255',
        ]);
        
        Task::create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'estimated_time' => $request->estimated_time,
        ]);

        return response()->json(['message' => 'Task created successfully']);
    }
}
