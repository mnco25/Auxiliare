<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Investor Home - Auxiliare')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/investor/home.css') }}">
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
                <li><a href="{{ route('investor.home') }}" class="{{ request()->routeIs('investor.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('investor.projects') }}" class="{{ request()->routeIs('investor.projects') ? 'active' : '' }}">Projects</a></li>
                <li><a href="{{ route('investor.portfolio') }}" class="{{ request()->routeIs('investor.portfolio') ? 'active' : '' }}">Portfolio</a></li>
                <li><a href="{{ route('investor.financial') }}" class="{{ request()->routeIs('investor.financial') ? 'active' : '' }}">Financial</a></li>
                <li><a href="#messaging">Chat</a></li>
                <li><a href="{{ route('investor.profile') }}" class="{{ request()->routeIs('investor.profile') ? 'active' : '' }}">Profile</a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
            </ul>
        </nav>
    </header>

    <form id="logout-form" action="{{ route('investor.logout') }}" method="POST" style="display: none;">
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