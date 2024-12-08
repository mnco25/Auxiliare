@extends('entrepreneur.layout')

@section('title', 'Home - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
<style>
    .greeting-section {
        padding: 2rem 0;
        margin-bottom: 3rem;
        position: relative;
        display: flex;
        justify-content: center;
        text-align: center;
    }

    .greeting-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .greeting-text {
        font-size: 2.6rem;
        font-weight: 700;
        color: #1f2b77;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .greeting-text i {
        color: #3d5af1;
        font-size: 2.2rem;
    }

    .greeting-time {
        font-size: 1.2rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .greeting-time i {
        color: #3d5af1;
    }

    /* Gradient line below greeting */
    .greeting-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
        height: 2px;
        background: linear-gradient(
            90deg,
            rgba(61, 90, 241, 0),
            rgba(31, 43, 119, 0.3),
            rgba(61, 90, 241, 0)
        );
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .greeting-section {
        animation: fadeIn 0.4s ease;
    }

    @media (max-width: 768px) {
        .greeting-text {
            font-size: 2rem;
        }

        .greeting-time {
            font-size: 1rem;
        }
    }
</style>
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
                    <h2>Get Started with Your Idea</h2>
                    <hr>
                </header>
                <div class="card-body">
                    <p>Every great success story begins with an idea, but it’s the courage to act that turns dreams into reality. Auxiliare is here to empower you with the tools, community, and opportunities to bring your vision to life. Whether you’re creating something new or refining an existing idea, today is the day to take that first bold step. Your journey to innovation and impact starts now—let’s shape the future together.</p>
                    <a href="{{ route('entrepreneur.create_project') }}" class="cta-button">Create New Project</a>
                    <a href="#edit-project" class="cta-button">Edit Existing Project</a>
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