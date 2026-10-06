@extends('layouts.base')

@section('content')
<main>
    <section class="d-flex align-items-center">
        <div class="container  py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <h1 class="display-4 fw-bold mb-4">Users</h1>
                    <p><a href="{{route("users.create")}}" class="btn btn-info">+ Add New User</a></p>
                    <hr>

                    <form id="user-filter-form" class="row g-3 mb-4">

                        <div class="col-md-3">
                            <label for="filter-name" class="form-label fw-semibold">Name</label>
                            <input type="text" id="filter-name" name="name" class="form-control" placeholder="Search by Name...">
                        </div>
                        <div class="col-md-3">
                            <label for="filter-email" class="form-label fw-semibold">Email</label>
                            <input type="text" id="filter-email" name="email" class="form-control" placeholder="Search by Email...">
                        </div>
                        <div class="col-6 gap-2 mt-5">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ request()->url() }}" class="btn btn-outline-secondary">Reset</a>
                        </div>

                    </form>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tasks Assigned</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body">
                            <!-- User rows will be dynamically inserted here -->

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
    function fetchUsers(params) {
        const query = new URLSearchParams(params).toString();
        $.ajax({
            url: '/api/users' + (query ? `?${query}` : ''),
            method: 'GET',
            success: function(response) {

                var users = response.data;
                const tbody = $('#users-table-body');
                tbody.empty();
                if (users.length === 0) {
                    tbody.append(`<tr><td colspan="4" class="text-center text-muted py-4">No users found.</td></tr>`);
                    return;
                }
                users.forEach(user => {
                    const row = `
                    <tr>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td><a href="/users/${user.id}/tasks" style="text-decoration: none; color: inherit;"> ${user.num_of_tasks}</a></td>

                        <td>
                            <a href="/users/${user.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                            <a href="/users/${user.id}/delete" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                `;
                    tbody.append(row);
                })
            },
            error: function(error) {
                console.error('Error fetching users:', error);
            }

        });

    }

    $(document).ready(function() {
        $('#user-filter-form').on('submit', function(event) {
            event.preventDefault();

            const params = {
                name: $('#filter-name').val().trim(),
                email: $('#filter-email').val().trim()
            };

            fetchUsers(params);
        });

        fetchUsers({});
    });
</script>
@endsection