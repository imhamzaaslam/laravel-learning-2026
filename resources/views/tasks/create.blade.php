@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center">
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <h1 class="display-4 fw-bold mb-4">Create Task</h1>
                        <p><a href="{{ route('tasks.list') }}" class="btn btn-info">&larr; Back to Tasks</a></p>
                        <hr>
                        <form id="create-task-form">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Assigned To</label>
                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date">
                            </div>

                            <div class="mb-3">
                                <label for="estimated_time" class="form-label">Estimated Time</label>
                                <input type="text" class="form-control" id="estimated_time" name="estimated_time">
                            </div>

                            <button type="submit" class="btn btn-primary">Create Task</button>

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
        $('#create-task-form').on('submit', function(e) {
            e.preventDefault();

            const title = $('#title').val();
            const user_id = $('#user_id').val();
            const description = $('#description').val();
            const due_date = $('#due_date').val();
            const estimated_time = $('#estimated_time').val();

            $.ajax({
                url: '/api/tasks',
                method: 'POST',
                data: {
                    title,
                    description,
                    due_date,
                    user_id,
                    estimated_time
                },
                success: function(response) {
                    alert('Task created successfully!');
                    window.location.href = "{{ route('tasks.list') }}";
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
