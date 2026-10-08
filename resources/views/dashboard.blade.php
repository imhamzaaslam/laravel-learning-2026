@extends('layouts.base')

@section('content')

<main class="dashboard-page">
    <div class="container">
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                
                <h1 class="dashboard-title mb-2">Welcome {{ auth()->user()?->name }}!</h1>
                
            </div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary px-3 py-2">+ Add New Task</a>
        </div>

        <section class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-3 mb-4" aria-label="Task summary">
            <div class="col">
                <article class="dashboard-stat" style="--stat-accent: #2878c8;">
                    <p class="dashboard-stat-label">All tasks</p>
                    <p class="dashboard-stat-value">{{ $stats['totalTasks'] }}</p>
                </article>
            </div>
            <div class="col">
                <article class="dashboard-stat" style="--stat-accent: #d89b21;">
                    <p class="dashboard-stat-label">Pending</p>
                    <p class="dashboard-stat-value">{{ $stats['pendingTasks'] }}</p>
                </article>
            </div>
            <div class="col">
                <article class="dashboard-stat" style="--stat-accent: #4386c5;">
                    <p class="dashboard-stat-label">In progress</p>
                    <p class="dashboard-stat-value">{{ $stats['inProgressTasks'] }}</p>
                </article>
            </div>
            <div class="col">
                <article class="dashboard-stat" style="--stat-accent: #32956b;">
                    <p class="dashboard-stat-label">Completed</p>
                    <p class="dashboard-stat-value">{{ $stats['completedTasks'] }}</p>
                </article>
            </div>
            <div class="col">
                <a href="{{ Route('tasks.list', ['filter' => 'overdue']) }}" class="text-decoration-none text-reset d-block">
                    <article class="dashboard-stat" style="--stat-accent: #cf5c50;">
                        <p class="dashboard-stat-label">Overdue</p>
                        <p class="dashboard-stat-value">{{ $stats['overdueTasks'] }}</p>
                    </article>
                </a>
            </div>
        </section>

        <div class="row g-4">
            <section class="col-lg-8" aria-labelledby="upcoming-tasks-heading">
                <div class="dashboard-panel">
                    <div class="dashboard-panel-heading d-flex align-items-center justify-content-between gap-3">
                        <h2 id="upcoming-tasks-heading">Upcoming tasks</h2>
                        <a href="{{ route('tasks.list') }}" class="small fw-semibold text-decoration-none">View all</a>
                    </div>

                    @if ($upcomingTasks->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table dashboard-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Task</th>
                                    <th scope="col">Assigned to</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Due date</th>
                                    <th scope="col"><span class="visually-hidden">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($upcomingTasks as $task)
                                @php
                                $taskStatus = $task->status ?? 'pending';
                                $statusClass = str_replace('_', '-', $taskStatus);
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $task->title }}</td>
                                    <td>{{ $task->user?->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="dashboard-status dashboard-status-{{ $statusClass }}">
                                            {{ ucwords(str_replace('_', ' ', $taskStatus)) }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">{{ $task->due_date?->format('M j, Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('tasks.details', $task->id) }}" class="btn btn-sm btn-outline-secondary">Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="dashboard-empty">
                        <p class="fw-semibold text-dark mb-1">Nothing coming up</p>
                        <p class="small mb-3">Create a task with a due date to see it here.</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-outline-primary">Create a task</a>
                    </div>
                    @endif
                </div>
            </section>

            <aside class="col-lg-4" aria-label="Workspace shortcuts">
                <div class="dashboard-panel p-4">
                    <p class="text-uppercase small fw-bold text-primary mb-2">People</p>
                    <p class="dashboard-people-count mb-2">{{ $stats['totalUsers'] }}</p>
                    <p class="dashboard-subtitle mb-4">{{ $stats['totalUsers'] === 1 ? 'user' : 'users' }} in your workspace</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.list') }}" class="btn btn-outline-secondary text-start">Browse users</a>
                        <a href="{{ route('tasks.list') }}" class="btn btn-outline-secondary text-start">Browse all tasks</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection