@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center">
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <h1 class="display-4 fw-bold mb-4">Edit Task</h1>
                        <p><a href="{{ route('tasks.list') }}" class="btn btn-info">&larr; Back to Tasks</a></p>
                        <hr>
                        @include('tasks._shared.task_form', compact('users', 'task'))
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

            const task_id = $('#task-id').val();
            const title = $('#title').val();
            const user_id = $('#user_id').val();
            const description = $('#description').val();
            const due_date = $('#due_date').val();
            const estimated_time = $('#estimated_time').val();

            //handle file attachments
            var attachments = $('#attachments')[0].files;


            $.ajax({
                url: '/api/tasks',
                method: 'POST',
                processData: false,
                contentType: false,
                data: (function() {
                    var formData = new FormData();
                    formData.append('task_id', task_id);
                    formData.append('title', title);
                    formData.append('user_id', user_id);
                    formData.append('description', description);
                    formData.append('due_date', due_date);
                    formData.append('estimated_time', estimated_time);

                    for (var i = 0; i < attachments.length; i++) {
                        formData.append('attachments[]', attachments[i]);
                    }

                    return formData;
                })(),
                success: function(response) {
                    alert('Task created successfully!');
                    window.location.href = "{{ route('tasks.list') }}";
                },
                error: function(error) {

                    var errors = error.responseJSON.errors;
                    var errorHtml = '<ul class="list-group">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li class="list-group-item list-group-item-danger">' +
                            value[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#form-errors').html(errorHtml);
                }
            });
        });
    </script>
@endsection
