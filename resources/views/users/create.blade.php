@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center">
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <h1 class="display-4 fw-bold mb-4">Create User</h1>
                        <p><a href="{{ route('users.create') }}" class="btn btn-info">+ Add New User</a></p>
                        <hr>
                        <form id="create-user-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" >
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" >
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="send_details" name="send_details">
                                <label for="send_details" class="form-check-label">Send details to User</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Create User</button>

                            <div class="mt-3" id="form-errors">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        

        $('#create-user-form').on('submit', function(e) {
            e.preventDefault();
        

            const name = $('#name').val();
            const email = $('#email').val();
            const password = $('#password').val();
            const confirm_password = $('#confirm_password').val();
            const send_details = $('#send_details').is(':checked');

            $.ajax({
                url: '/api/users',
                method: 'POST',
                // Include CSRF token in the request header
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name,
                    email,
                    password,
                    confirm_password,
                    send_details
                },
                success: function(response) {
                    alert('User created successfully!');
                    // Optionally, redirect to the users list page
                    //window.location.href = "{{ route('users.list') }}";
                },
                error: function(error) {
                    
                    var errors = error.responseJSON.errors;
                    var errorHtml = '<ul class="list-group">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li class="list-group-item list-group-item-danger">' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#form-errors').html(errorHtml);
                }
            });
        });
    </script>
    @endsection
