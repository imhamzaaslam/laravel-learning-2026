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

                    {{-- Filters --}}
                    <form id="filters-form" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="filter-title" class="form-label fw-semibold">Title</label>
                            <input type="text" id="filter-title" class="form-control" placeholder="Search by title...">
                        </div>
                        <div class="col-md-3">
                            <label for="filter-status" class="form-label fw-semibold">Status</label>
                            <select id="filter-status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filter-user" class="form-label fw-semibold">Assigned To</label>
                            <select id="filter-user" class="form-select">
                                <option value="">All Users</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filter-due-date" class="form-label fw-semibold">Due Date</label>
                            <input type="date" id="filter-due-date" class="form-control">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Apply</button>
                            <a href="{{ request()->url() }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>

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
    function fetchTasks(params) {
        const query = new URLSearchParams(params).toString();
        $.ajax({
            url: '/api/tasks' + (query ? '?' + query : ''),
            method: 'GET',
            success: function(response) {
                var tasks = response.data;
                const tbody = $('#tasks-table-body');
                tbody.empty();
                if (tasks.length === 0) {
                    const isOverdueView = (params.filter === 'overdue');
                    const message = isOverdueView ? 'There are no overdue tasks.' : 'No tasks found.';
                    tbody.append(`<tr><td colspan="7" class="text-center text-muted py-4">${message}</td></tr>`);
                    return;
                }
                tasks.forEach(task => {
                    const row = `
                        <tr>
                            <td>${task.title}</td>
                            <td class="${task.user?.name ?? 'text-danger'}">${task.user?.name ?? 'Unassigned'}</td>
                            <td><select id="filter-status" class="form-select">
                                    <option value="pending" ${task.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="in_progress" ${task.status === 'in_progress' ? 'selected' : ''}>In Progress</option>
                                    <option value="completed" ${task.status === 'completed' ? 'selected' : ''}>Completed</option>
                                </select></td>
                            <td>${task.due_date ?? ''}</td>
                            <td>${task.estimated_time ?? ''}</td>
                            <td>${task.created_at ?? ''}</td>
                            <td>
                                <a href="/tasks/${task.id}" class="btn btn-sm btn-primary">Details</a>
                                <a href="/tasks/${task.id}/edit" class="btn btn-sm btn-secondary">Edit</a>
                                <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">Delete</button>
                            </td>
                        </tr>`;
                    tbody.append(row);
                });
            },
            error: function(error) {
                console.error('Error fetching tasks:', error);
            }
        });
    }


    //FILTER TASKS

    $(document).ready(function() {
        // Populate users dropdown
        $.ajax({
            url: '/api/users',
            method: 'GET',
            success: function(response) {
                const users = response.data ?? response;
                users.forEach(function(user) {
                    $('#filter-user').append(`<option value="${user.id}">${user.name}</option>`);
                });
            }
        });

        // Seed inputs from current URL params
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('title')) $('#filter-title').val(urlParams.get('title'));
        if (urlParams.get('status')) $('#filter-status').val(urlParams.get('status'));
        if (urlParams.get('user_id')) $('#filter-user').val(urlParams.get('user_id'));
        if (urlParams.get('due_date')) $('#filter-due-date').val(urlParams.get('due_date'));

        // Initial load
        const initialParams = Object.fromEntries(urlParams.entries());
        fetchTasks(initialParams);

        // Filter form submit
        $('#filters-form').on('submit', function(e) {
            e.preventDefault();
            const params = {};
            const title = $('#filter-title').val().trim();
            const status = $('#filter-status').val();
            const userId = $('#filter-user').val();
            const dueDate = $('#filter-due-date').val();
            // Preserve overdue filter if present
            if (urlParams.get('filter')) params.filter = urlParams.get('filter');
            if (title) params.title = title;
            if (status) params.status = status;
            if (userId) params.user_id = userId;
            if (dueDate) params.due_date = dueDate;
            fetchTasks(params);
        });
    });


    //DELETE TASK

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

    //UPDATED TASK STATUS ON CHANGE

    $('#tasks-table-body').on('keydown', '.task-status', function(event) {

        if (event.key !== "Enter") return;
        event.preventDefault();

        const selected = $(this);
        const task_id = selected.data('task-id');

        $.ajax({
            url: `/api/tasks/${task_id}/status`,
            method: 'PATCH',
            data: {
                status: selected.val()
            },
            error: function(error) {
                console.error('Could not update task status', error.responseJSON);
            }
        });
    });