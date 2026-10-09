<?php

namespace App\Http\Controllers\Api;

use App\Mail\TaskCompletedMail;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function index(Request $request)
    {

        $query = Task::with('user');

        // if ($request->has('filter') && $request->input('filter') === 'overdue') {
        //     $query->where('due_date', '<', now())->where('status', '!=', 'completed');
        // }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->input('due_date'));
        }

        $tasks = $query->get();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
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

        if ($request->has('status')) {
            $taskRequestData['status'] = $request->input('status');
        }

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

    public function updateStatusValue(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task = Task::findOrFail($id);
        $task->update(['status' => $validated['status']]);

        return response()->json([
            'message' => 'Task status updated successfully.',
            'status' => $task->status,
        ]);
    }

    public function destroy($id)
    {

        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
