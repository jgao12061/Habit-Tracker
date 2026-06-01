<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Habit Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="d-flex bg-dark text-light">
    <div class="d-flex">
        <!--Sidebar-->
        <div class="sidebar bg-dark text-white p-3 d-flex flex-column">
            <h2 class="navbar-brand mb-4">Habit Tracker</h2>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">📊 Dashboard</a></li>
                <li class="nav-item"><a href="/admin/users" class="nav-link  {{ request()->is('admin/users') ? 'active' : '' }}">👥 Users</a></li>
                <li class="nav-item"><a href="/admin/habits" class="nav-link  {{ request()->is('admin/habits') ? 'active' : '' }}">🔥 Habits</a></li>
                <li class="nav-item"><a href="/profile/index" class="nav-link  {{ request()->is('profile/index') ? 'active' : '' }}">📷 Profile</a></li>
            </ul>

            <div class="mt-auto pt-3" style="border-top: 1px solid #1f1e2e;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-cancel-custom w-100 text-start"> 🔘 Logout</button>
            </form>
        </div>
        </div>
    </div>
</div>

    

     <div class="dashboard-body flex-grow-1 p-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
