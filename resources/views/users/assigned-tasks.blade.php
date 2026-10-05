@extends('layouts.base')

@section('content')
<main>
    <section>
        <div class="container py-5">
            <h1 class="display-4 fw-bold mb-2">Tasks Assigned to {{ $user->name }}</h1>
            <p class="text-muted">{{ $user->email }}</p>
            <hr>

            @if ($user->tasks->isEmpty())
            <p>No tasks are assigned to this user.</p>
            @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Estimated Time</th>
                            <th>Attachments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td><span class="badge text-bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : 'warning') }}">{{ ucwords(str_replace('_', ' ', $task->status)) }}</span></td>
                            <td>{{ $task->description ?: 'No description' }}</td>
                            <td>{{ $task->due_date?->format('d/M/Y') ?? 'Not set' }}</td>
                            <td>{{ $task->estimated_time ?? 'Not set' }}</td>
                            <td>
                                @forelse ($task->attachments as $attachment)
                                <a href="{{ asset($attachment->path) }}" target="_blank" rel="noopener noreferrer">{{ $attachment->name }}</a>@if (!$loop->last), @endif
                                @empty
                                None
                                @endforelse
                            </td>
                            <td><a href="{{ route('tasks.details', $task->id) }}" class="btn btn-sm btn-primary">View task</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <a href="{{ route('users.list') }}" class="btn btn-secondary">Back to Users</a>
        </div>
    </section>
</main>
@endsection