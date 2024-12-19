<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
    <meta name="theme-color" content="#0a1a3c" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Login & Register</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon_io/site.webmanifest') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="{{asset('css/login.css')}}" />
    <link rel="stylesheet" href="{{asset('css/index.css')}}" />
    <script>
        function showAlert(message, type = 'error') {
            alert(message); 
        }
    </script>
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

    <!-- Login Form -->
    @extends('layouts.app')

    @section('title', 'Login - Auxiliare')

    @section('content')
    <div class="half">
        <div class="container1">
            <section class="container3">
                <article class="card">
                    <header class="card-header">
                        <h2><i class="fas fa-user-circle"></i> Login</h2>
                    </header>
                    <form class="card-body" action="{{ route('login.submit') }}" method="POST" autocomplete="off">
                        @csrf <!-- CSRF Token -->

                        <div class="form-group">
                            <label for="login-email">
                                <i class="fas fa-envelope"></i>
                                <input 
                                    type="text"
                                    id="login-email" 
                                    name="login" 
                                    placeholder="Enter username or email" 
                                    class="form-control" 
                                    required 
                                    autocomplete="off"
                                />
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="login-password">
                                <i class="fas fa-lock"></i>
                                <input 
                                    type="password" 
                                    id="login-password" 
                                    name="password" 
                                    placeholder="Password" 
                                    class="form-control" 
                                    required
                                    autocomplete="current-password"
                                />
                            </label>
                        </div>

                        <div class="lower">
                            <button type="submit" class="btn">
                                Login <i class="fas fa-sign-in-alt"></i>
                            </button>
                        </div>

                        @if (session('error_message'))
                        <p style="color: red;">{{ session('error_message') }}</p>
                        @endif
                    </form>
                    <div class="register-link">
                        <p>Don't have an account? <a href="#" id="openModal" class="register-button">Register</a></p>
                    </div>
                </article>
            </section>
        </div>
        <div class="container2"></div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content card">
            <header class="card-header">
                <h2><i class="fas fa-user-plus"></i> Register</h2>
                <span id="closeModal" class="close">&times;</span>
            </header>
            <form class="card-body" action="{{ route('register.submit') }}" method="POST" id="registerForm">
                @csrf
                <div id="error-messages" class="alert alert-danger" style="display: none; color: red; margin-bottom: 15px;"></div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" placeholder="Enter username" class="form-control" required />
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Enter email" class="form-control" required />
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" class="form-control" required />
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required />
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user"></i>
                            <input type="text" name="first_name" placeholder="First Name" class="form-control" required />
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user"></i>
                            <input type="text" name="last_name" placeholder="Last Name" class="form-control" required />
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <i class="fas fa-users"></i>
                            <select name="user_type" class="form-control" required>
                                <option value="" disabled selected>Select Role</option>
                                <option value="Entrepreneur">Entrepreneur</option>
                                <option value="Investor">Investor</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="lower">
                    <button type="submit" class="btn">
                        Register <i class="fas fa-user-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endsection

    <script src="{{ asset('js/login-modal.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>