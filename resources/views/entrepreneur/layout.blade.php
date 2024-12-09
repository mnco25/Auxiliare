<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Entrepreneur Home - Auxiliare')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <li><a href="{{ route('entrepreneur.home') }}" class="{{ request()->routeIs('entrepreneur.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('entrepreneur.dashboard') }}" class="{{ request()->routeIs('entrepreneur.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('entrepreneur.create_project') }}" class="{{ request()->routeIs('entrepreneur.create_project') ? 'active' : '' }}">Create</a></li>
                <li><a href="{{ route('entrepreneur.financial') }}" class="{{ request()->routeIs('entrepreneur.financial') ? 'active' : '' }}">Financial</a></li>
                <li><a href="{{ route('entrepreneur.chat') }}" class="{{ request()->routeIs('entrepreneur.chat') ? 'active' : '' }}">Chat</a></li>
                <li class="notification-item">
                    <a href="#" class="notification-link">
                        <i class="fas fa-bell"></i>
                        <span class="notification-count">0</span>
                    </a>
                </li>
                <li><a href="{{ route('entrepreneur.profile') }}" class="{{ request()->routeIs('entrepreneur.profile') ? 'active' : '' }}">Profile</a></li>
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