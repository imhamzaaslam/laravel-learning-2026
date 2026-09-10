@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center"
            style="min-height: 80vh; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
            <div class="container text-center text-white py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <span class="badge rounded-pill bg-white text-primary px-3 py-2 mb-4 fw-semibold">Project Management
                            System</span>
                        <h1 class="display-4 fw-bold mb-4">Welcome Admin</h1>
                        <p class="fs-5 mb-0" style="color: rgba(255, 255, 255, 0.85);">
                            This is a test project built purely for educational purposes &mdash; a hands-on playground
                            to teach students the fundamentals of PHP, from handling forms and data to building
                            simple, real-world features step by step. It's not a production application, just a
                            friendly space to learn by doing.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
