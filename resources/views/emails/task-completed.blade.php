<div>
    <h1>You've been Completed task</h1>
    <p>Hi {{ $task->user->name }},</p>
    <p>You have Completed the following task:</p>
    <h2>{{ $task->title }}</h2>
    @if ($task->description)
    <p>{{ $task->description }}</p>
    @endif
    <ul>
        <li><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $task->status)) }}</li>
        <li><strong>Due Date:</strong> {{ $task->due_date?->format('d/M/Y') ?? 'N/A' }}</li>
        <li><strong>Estimated Time:</strong> {{ $task->estimated_time ?? 'N/A' }}</li>
    </ul>
    <a href="{{ route('tasks.details', $task->id) }}" style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View Task</a>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</div>