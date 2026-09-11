@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center"
            >
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        
                        <h1 class="display-4 fw-bold mb-4">Task Details</h1>
                        <hr>
                        <div>
                            <p><Strong>Title:</Strong> {{ $task->title }}</p>
                            <p><Strong>Description:</Strong> {{ $task->description }}</p>
                            <p><Strong>Due Date:</Strong> {{ $task->due_date->format('d/M/Y') }}</p>
                            <p><Strong>Estimated Time:</Strong> {{ $task->estimated_time }}</p>
                            <p><Strong>Created At:</Strong> {{ $task->created_at->format('d/M/Y H:i:s') }}</p>

                            <a  href="{{ route('tasks.list') }}" class="btn btn-secondary">Back to Task List</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
