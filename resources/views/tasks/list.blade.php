@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center"
            >
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <h1 class="display-4 fw-bold mb-4">Tasks</h1>
                        <p><a href="{{ route('tasks.create') }}" class="btn btn-info">+ Add New Task</a></p>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Assigned To</th>
                                    <th>Due Date</th>
                                    <th>Estimated Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tasks-table-body">
                                <!-- Task rows will be dynamically inserted here -->

                            </tbody>
                        </table>
                    </div>
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
                url: '/api/tasks',
                method: 'GET',
                success: function(tasks) {
                    // Populate the table with task data
                    const tbody = $('#tasks-table-body');
                    tbody.empty(); // Clear existing rows

                    tasks.forEach(task => {
                        const row = `
                            <tr>
                                <td>${task.title}</td>
                                <td class="${task.user?.name??'text-danger'}">${task.user?.name??'Unassigned'}</td>
                                <td>${task.due_date ?? ''}</td>
                                <td>${task.estimated_time ?? ''}</td>
                                <td>
                                    <a href="/tasks/${task.id}" class="btn btn-sm btn-primary btn-sm">View Details</a>

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
