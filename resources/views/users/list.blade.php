@extends('layouts.base')

@section('content')
    <main>
        <section class="d-flex align-items-center"
            >
            <div class="container  py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        
                        <h1 class="display-4 fw-bold mb-4">Users</h1>
                        <hr>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            
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
