<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Auxiliare')</title>
    <!-- Add Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon_io/site.webmanifest') }}">
    <!-- Existing CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{asset('css/index.css')}}" />
    @yield('additional_css')
</head>

<body>
    <header class="main-header">
        <div class="logo-container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/logo.png') }}" alt="AUXILIARE logo" class="logo" />
            </a>
            <h2 class="homelogotext">AUXILIARE</h2>
        </div>
        <button class="mobile-nav-toggle" aria-label="Toggle navigation menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <nav aria-label="Main Navigation">
            <ul class="nav-menu">
                <li><a href="{{ url('/') }}" class="nav-button">Home</a></li>
                <li><a href="{{ url('/about') }}" class="nav-button">About</a></li>
                <li><a href="#features" class="nav-button">Features</a></li>
                <li><a href="#faq" class="nav-button">FAQ</a></li>
                <li><a href="#contact" class="nav-button">Contact</a></li>
                <li><a href="{{ url('/pricing') }}" class="nav-button">Pricing</a></li>
                <li><a href="{{ url('/login') }}" class="nav-button">Login</a></li>
            </ul>
        </nav>
    </header>

    @yield('content')

    <button id="scroll-to-top" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <footer class="main-footer">
        <p>&copy; 2024 AUXILIARE | All Rights Reserved</p>
    </footer>

    <!-- Base Scripts -->
    <script src="{{ asset('js/navigation.js') }}"></script>
    <!-- Additional Page Scripts -->
    @yield('scripts')
</body>

</html>