<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Entrepreneur Dashboard - Auxiliare')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/entrepreneur/dashboard.css') }}">
    @yield('additional_css')
</head>

<body>
    <header class="main-header">
        <div class="logo-container">
            <img src="{{ asset('assets/logo.png') }}" alt="Auxiliare Logo" class="logo" />
            <h2 class="dashboardlogotext">AUXILIARE</h2>
        </div>
        <nav aria-label="Main Navigation">
            <ul class="nav-menu">
                <li><a href="{{ route('entrepreneur.dashboard') }}" class="{{ request()->routeIs('entrepreneur.dashboard') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('entrepreneur.create_project') }}" class="{{ request()->routeIs('entrepreneur.create_project') ? 'active' : '' }}">Create</a></li>
                <li><a href="#messaging">Chat</a></li>
                <li><a href="#profile">Profile</a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
            </ul>
        </nav>
    </header>

    <form id="logout-form" action="{{ route('entrepreneur.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <main class="content">
        @yield('content')
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 AUXILIARE | All Rights Reserved</p>
    </footer>

    @yield('scripts')
</body>

</html>