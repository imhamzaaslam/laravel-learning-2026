@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center"
            >
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        
                        <h1 class="display-4 fw-bold mb-4">Users</h1>
                        <p><a href="{{route("users.create")}}" class="btn btn-info" >+ Add New User</a></p>
                        <hr>
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
        $(document).ready(function() {
            // Fetch users from the API
            $.ajax({
                url: '/api/users',
                method: 'GET',
                success: function(response) {
                    var users = response.data;
                    // Populate the table with user data
                    const tbody = $('#users-table-body');
                    tbody.empty(); // Clear existing rows

                    users.forEach(user => {
                        const row = `
                            <tr>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.num_of_tasks}</td>
                                <td>
                                    <a href="/users/${user.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="/users/${user.id}/delete" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                },
                error: function(error) {
                    console.error('Error fetching users:', error);
                }
            });
        });
    </script>
    @endsection
