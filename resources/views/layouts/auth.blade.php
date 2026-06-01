<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auth Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{  asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        @yield('content')

    </div>
</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>