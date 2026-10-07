@extends('layouts.base')

@section('content')
<main>
    <section class="py-5" style="background: #f5f7fb; min-height: calc(100vh - 140px);">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-9">

                    @if (session('success'))
                        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
                    @endif

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-dark text-white p-4 border-0">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                <div>
                                    <div class="text-uppercase small text-white-50 mb-1">Task Details</div>
                                    <h1 class="h3 fw-bold mb-0">{{ $task->title }}</h1>
                                </div>
                                <span class="badge rounded-pill fs-6 px-3 py-2 text-bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'primary' : 'warning') }}">
                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4 p-md-5">

                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted small fw-semibold mb-2">Description</h6>
                                <p class="mb-0 text-body">{{ $task->description ?: 'No description provided.' }}</p>
                            </div>

                            <hr class="my-4">

                            <div class="row g-4 mb-4">
                                <div class="col-sm-6 col-lg-3">
                                    <div class="p-3 rounded-3 bg-light h-100">
                                        <div class="text-muted small mb-1"><i class="bi bi-calendar-event"></i> Due Date</div>
                                        <div class="fw-semibold">{{ $task->due_date?->format('d/M/Y') ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="p-3 rounded-3 bg-light h-100">
                                        <div class="text-muted small mb-1">Estimated Time</div>
                                        <div class="fw-semibold">{{ $task->estimated_time ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="p-3 rounded-3 bg-light h-100">
                                        <div class="text-muted small mb-1">Created At</div>
                                        <div class="fw-semibold">{{ $task->created_at->format('d/M/Y H:i:s') }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="p-3 rounded-3 bg-light h-100">
                                        <div class="text-muted small mb-1">Assigned To</div>
                                        <div class="fw-semibold">
                                            @if ($task->user)
                                                {{ $task->user->name }}
                                            @else
                                                <span class="text-muted">Unassigned</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted small fw-semibold mb-2">Attachments</h6>
                                @if ($task->attachments && $task->attachments->count())
                                    <ul class="list-group list-group-flush">
                                        @foreach ($task->attachments as $attachment)
                                            <li class="list-group-item px-0 d-flex align-items-center justify-content-between">
                                                <a href="{{ asset($attachment->path) }}" target="_blank" class="text-decoration-none">
                                                    {{ $attachment->name }}
                                                </a>
                                                <span class="text-muted small">{{ $attachment->size }} kb</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">No attachments.</p>
                                @endif
                            </div>

                            <hr class="my-4">

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('tasks.list') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                    &larr; Back to Task List
                                </a>

                                @if ($task->user)
                                    
                                        <a href="{{ route('tasks.send-assignment-email', $task->id) }}" class="btn btn-primary rounded-pill px-4">
                                            Send Assignment Email to {{ $task->user->name }}
                                        </a>
                                    
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
@endsection
