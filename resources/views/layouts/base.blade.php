<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootstrap Course Starter</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Bootstrap Course</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.list') }}">Users</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('tasks*') ? 'active' : '' }}" href="{{ route('tasks.list') }}">Tasks</a>
                        </li>






                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreDropdown">
                                <li><a class="dropdown-item" href="week3/day1.html">Day 1: JS Basics</a></li>
                                <li><a class="dropdown-item" href="week3/day2.html">Day 2: Loops & Functions</a></li>
                                <li><a class="dropdown-item" href="week3/day3.html">Day 3: Arrays & Objects</a></li>
                                <li><a class="dropdown-item" href="week3/day4.html">Day 4: DOM Manipulation</a></li>
                                <li><a class="dropdown-item" href="week3/day5.html">Day 5: Async JS</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown ms-3">
                            <button class="btn btn-outline-light btn-sm rounded-circle dropdown-toggle" type="button"
                                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width: 40px; height: 40px; padding: 0;">
                                <span class="fw-bold">IN</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <h6 class="dropdown-header">Instructor</h6>
                                </li>
                                <li><a class="dropdown-item" href="#contact">My Profile</a></li>
                                <li><a class="dropdown-item" href="#features">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Sign Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="py-4 bg-dark text-white">
        <div class="container text-center">
            <p class="mb-1">Bootstrap Course Starter · Built with Bootstrap 5</p>
            <small>Use the assets directory for your local CSS and JS files.</small>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    @yield('scripts')

</body>

</html>