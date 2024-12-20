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
        <button 
            class="mobile-nav-toggle" 
            aria-label="Toggle navigation menu"
            aria-expanded="false"
            aria-controls="nav-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <nav aria-label="Main Navigation" class="main-nav">
            <ul class="nav-menu" role="menubar">
                <li role="none">
                    <a href="{{ url('/') }}" class="nav-button" role="menuitem">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/about') }}" class="nav-button" role="menuitem">
                        <i class="fas fa-info-circle"></i>
                        <span>About</span>
                    </a>
                </li>
                <li role="none">
                    <a href="#features" class="nav-button" role="menuitem">
                        <i class="fas fa-star"></i>
                        <span>Features</span>
                    </a>
                </li>
                <li role="none">
                    <a href="#faq" class="nav-button" role="menuitem">
                        <i class="fas fa-question-circle"></i>
                        <span>FAQ</span>
                    </a>
                </li>
                <li role="none">
                    <a href="#contact" class="nav-button" role="menuitem">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/pricing') }}" class="nav-button" role="menuitem">
                        <i class="fas fa-tags"></i>
                        <span>Pricing</span>
                    </a>
                </li>
                <li role="none">
                    <a href="{{ url('/login') }}" class="nav-button" role="menuitem">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                </li>
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
    <script src="{{ asset('js/mobile-menu.js') }}"></script>
    <!-- Additional Page Scripts -->
    @yield('scripts')
</body>

</html>