@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center"
            >
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        
                        <h1 class="display-4 fw-bold mb-4">Tasks</h1>
                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Due Date</th>
                                    <th>Estimated Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->due_date->format('d/M/Y') }}</td>
                                        <td>{{ $task->estimated_time }}</td>
                                        <td>
                                            <a href="{{ route('tasks.details', ['id' => $task->id]) }}" class="btn btn-primary">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
