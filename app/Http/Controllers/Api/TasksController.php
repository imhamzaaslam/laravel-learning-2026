<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->get();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'estimated_time' => 'nullable|string|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:2048|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        ]);

        $taskRequestData = [
                'title' => $request->title,
                'user_id' => $request->user_id,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'estimated_time' => $request->estimated_time,
        ];

        if ($request->has('task_id')) {
            $taskId = $request->input('task_id');
            $task = Task::findOrFail($taskId);
            $task->update($taskRequestData);
        } else {
            $taskRequestData['uuid'] = Str::uuid();
            $task = Task::create($taskRequestData);
        }

        // Handle attachments if provided
        if ($request->hasFile('attachments')) {
            $taskId = $task->id;
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('attachments', 'public');
                $task->attachments()->create([
                    'path' => $path,
                    'name' => $attachment->getClientOriginalName(),
                    'type' => $attachment->getClientMimeType(),
                    'size' => $attachment->getSize(),
                ]);
            }
        }

        return response()->json(['message' => 'Task created successfully']);
    }

    public function destroy($id){
        
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
