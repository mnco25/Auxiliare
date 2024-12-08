@extends('investor.layout')

@section('title', 'Home - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/investor/home.css') }}">
@endsection

@section('content')
<div class="home-container">
    <div class="greeting-section">
        <div class="greeting-content">
            <div class="greeting-text" id="greetingText">
                <!-- Greeting will be inserted here by JS -->
            </div>
            <div class="greeting-time" id="currentTime">
                <i class="fas fa-clock"></i>
                <!-- Current time will be inserted here by JS -->
            </div>
        </div>
    </div>

    <div class="half">
        <div class="container4">
            <section class="card4">
                <header class="card-header">
                    <h2>Start Investing in Innovation</h2>
                    <hr>
                </header>
                <div class="card-body">
                    <p>At Auxiliare, we bring you closer to the world of high-potential startups. As an investor, you have the opportunity to explore innovative projects, connect with passionate entrepreneurs, and provide the financial support that helps turn visionary ideas into thriving businesses. Your participation can shape industries, create jobs, and be part of the next wave of groundbreaking solutions.</p>
                    <a href="{{ route('investor.projects') }}" class="cta-button">Search Available Projects</a>
                    <a href="{{ route('investor.portfolio') }}#dashboard-card" class="cta-button">See your Funding Portfolio</a>
                </div>
            </section>
        </div>

        <div class="container4">
            <section class="card5">
                <header class="card-header">
                    <h2>Auxiliare</h2>
                    <hr>
                </header>
                <div class="card-body">
                    <p>
                        <hr>Auxiliare is dedicated to creating a digital platform that blends entrepreneurship with investment and research, fostering a sustainable environment in which startups can attain networking and funding opportunities. The platform streamlines the path for entrepreneurs from inception to market success. Auxiliare ensures that the entrepreneurial spirit is nurtured with the right tools, enabling collaboration and investment, which continue to drive vibrant community ideas towards global success.
                    </p>
                    <div class="lower"></div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateGreeting() {
        const now = new Date();
        const hour = now.getHours();
        const name = "{{ $firstname }}";

        let greeting;
        let icon;
        if (hour >= 5 && hour < 12) {
            greeting = "Good Morning";
            icon = "sun";
        } else if (hour >= 12 && hour < 17) {
            greeting = "Good Afternoon";
            icon = "cloud-sun";
        } else if (hour >= 17 && hour < 22) {
            greeting = "Good Evening";
            icon = "moon";
        } else {
            greeting = "Good Night";
            icon = "stars";
        }

        document.getElementById('greetingText').innerHTML =
            `<i class="fas fa-${icon}"></i>${greeting}, ${name}!`;
    }

    function updateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        };

        document.getElementById('currentTime').innerHTML =
            `<i class="fas fa-clock"></i>${now.toLocaleTimeString('en-US', options)}`;
    }

    // Initial update
    updateGreeting();
    updateTime();

    // Update time every minute instead of every second
    setInterval(updateTime, 60000);
    setInterval(updateGreeting, 60000);
</script>
@endsection