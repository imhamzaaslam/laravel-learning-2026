@extends('layouts.base')

@section('content')
<main>

    @php
    $isOverdueView = request()->query('filter') === 'overdue';
    @endphp
    <section class="d-flex align-items-center">
        <div class="container  py-5">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                        <div>
                            <h1 class="display-4 fw-bold mb-2">
                                {{ $isOverdueView ? 'Overdue tasks' : 'Tasks' }}
                            </h1>

                            @if ($isOverdueView)
                            <p class="text-muted mb-3">
                                Tasks past their due date that are not completed.
                            </p>
                            @endif
                        </div>
                        <p><a href="{{ route('tasks.create') }}" class="btn btn-info">+ Add New Task</a></p>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Estimated Time</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tasks-table-body">
                                <!-- Task rows will be dynamically inserted here -->

                            </tbody>
                        </table>
                </div>
            </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Fetch tasks from the API
        $.ajax({
            url: '/api/tasks' + window.location.search,
            method: 'GET',
            success: function(response) {
                var tasks = response.data;
                // Populate the table with task data
                const tbody = $('#tasks-table-body');
                tbody.empty(); // Clear existing rows
                if (tasks.length === 0) {
                    const isOverdueView =
                        new URLSearchParams(window.location.search).get('filter') === 'overdue';

                    const message = isOverdueView ?
                        'There are no overdue tasks.' :
                        'No tasks found.';

                    tbody.append(
                        `<tr><td colspan="7" class="text-center text-muted py-4">${message}</td></tr>`
                    );
                    return;
                }

                tasks.forEach(task => {
                    const row = `
                            <tr>
                                <td>${task.title}</td>
                                <td class="${task.user?.name??'text-danger'}">${task.user?.name??'Unassigned'}</td>
                                <td><span class="badge text-bg-${task.status === 'completed' ? 'success' : (task.status === 'in_progress' ? 'primary' : 'warning')} text-capitalize">${(task.status ?? 'pending').replace('_', ' ')}</span></td>
                                <td>${task.due_date ?? ''}</td>
                                <td>${task.estimated_time ?? ''}</td>
                                <td>${task.created_at ?? ''}</td>
                                <td>
                                    <a href="/tasks/${task.id}" class="btn btn-sm btn-primary btn-sm">Details</a>

                                    <a href="/tasks/${task.id}/edit" class="btn btn-sm btn-secondary btn-sm">Edit</a>

                                    <button class="btn btn-sm btn-danger btn-sm" onclick="deleteTask(${task.id})">Delete</button>
                                </td>
                            </tr>
                        `;
                    tbody.append(row);
                });
            },
            error: function(error) {
                console.error('Error fetching tasks:', error);
            }
        });
    });

    function deleteTask(taskId) {
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: `/api/tasks/${taskId}`,
                method: 'DELETE',
                success: function() {
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error deleting task:', error);
                }
            });
        }
    }
</script>
@endsection