<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Login & Register - Auxiliare')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{asset('css/login.css')}}" />
    <link rel="stylesheet" href="{{asset('css/index.css')}}" />
</head>

<body>
    <header class="main-header">
        <div class="logo-container">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/logo.png') }}" alt="AUXILIARE logo" class="logo" />
            </a>
            <h2 class="homelogotext">AUXILIARE</h2>
        </div>
        <nav aria-label="Main Navigation">
            <ul class="nav-menu">
                <li><a href="{{ url('/') }}" class="nav-button">Home</a></li>
                <li><a href="{{ url('/about') }}" class="nav-button">About</a></li>
                <li><a href="{{ url('/') }}#features" class="nav-button">Features</a></li>
                <li><a href="{{ url('/') }}#faq" class="nav-button">FAQ</a></li>
                <li><a href="{{ url('/') }}#contact" class="nav-button">Contact</a></li>
                <li><a href="{{ url('/pricing') }}" class="nav-button">Pricing</a></li>
                <li><a href="{{ url('/login') }}" class="nav-button">Login</a></li>
            </ul>
        </nav>
    </header>

    @yield('content')

    <script src="{{ mix('js/app.js') }}" defer></script>
</body>

</html>