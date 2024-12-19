@extends('layouts.app')

@section('additional_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
@endsection

@section('content')
<main class="hero-section">
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="animate-text">Welcome to Auxiliare</h1>
        <p class="hero-text">
            Connect with investors, showcase your projects, and turn your
            entrepreneurial dreams into reality.
        </p>
        <div class="cta-buttons">
            <a href="{{ url('/login') }}" class="cta-button primary pulse">Get Started</a>
            <a href="#features" class="cta-button secondary">Learn More</a>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="mouse"></div>
        <p>Scroll to explore</p>
    </div>
</main>

<section id="features" class="features-section">
    <h2 data-aos="fade-up">Why Choose Auxiliare?</h2>
    <div class="features-grid">
        <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <h3>Connect with Investors</h3>
            <p>
                Find the right investors who believe in your vision and can help
                fund your projects.
            </p>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <h3>Showcase Projects</h3>
            <p>
                Present your ideas professionally and attract the attention they
                deserve.
            </p>
        </div>
        <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Build Networks</h3>
            <p>
                Connect with other entrepreneurs and build valuable professional
                relationships.
            </p>
        </div>
    </div>
</section>

<section class="stats-section" data-aos="fade-up">
    <div class="stats-container">
        <div class="stat-item">
            <span class="stat-number" data-target="500">0</span>
            <span class="stat-label">Active Projects</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" data-target="1000">0</span>
            <span class="stat-label">Entrepreneurs</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" data-target="250">0</span>
            <span class="stat-label">Investors</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" data-target="10">0</span>
            <span class="stat-label">Million $ Funded</span>
        </div>
    </div>
</section>

<section class="for-whom-section">
    <div class="section-container">
        <div class="for-entrepreneurs" data-aos="fade-right">
            <h2>For Entrepreneurs</h2>
            <div class="benefits-list">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>Secure Funding</h3>
                    <p>Connect with investors ready to fund your vision</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3>Expert Mentorship</h3>
                    <p>Get guidance from industry veterans</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Project Showcase</h3>
                    <p>Present your ideas on a global platform</p>
                </div>
            </div>
        </div>

        <div class="for-investors" data-aos="fade-left">
            <h2>For Investors</h2>
            <div class="benefits-list">
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Curated Opportunities</h3>
                    <p>Access pre-vetted investment opportunities</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3>Portfolio Management</h3>
                    <p>Track and manage your investments easily</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Exclusive Network</h3>
                    <p>Connect with other investors and entrepreneurs</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="faq" class="faq-section" data-aos="fade-up">
    <h2>Frequently Asked Questions</h2>
    <div class="faq-container">
        <div class="faq-item">
            <button class="faq-button">
                <span>How do I get started as an entrepreneur?</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="faq-content">
                <p>
                    Create an account, complete your profile, and start by creating
                    your first project proposal. Our platform guides you through each
                    step of the process.
                </p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-button">
                <span>What types of projects can I invest in?</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="faq-content">
                <p>
                    We offer a diverse range of investment opportunities across
                    technology, healthcare, renewable energy, and more. Each project
                    is carefully vetted to ensure quality.
                </p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-button">
                <span>How is my investment protected?</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="faq-content">
                <p>
                    We implement strict verification processes and legal frameworks to
                    ensure secure investments. Our platform uses bank-grade security
                    and follows all regulatory requirements.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="contact-section" data-aos="fade-up">
    <h2 data-aos="fade-up" data-aos-duration="800">Get in Touch</h2>
    <div class="contact-container">
        <form class="contact-form" action="contact.php" method="POST">
            <div class="form-group">
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    placeholder="Your Name" />
            </div>
            <div class="form-group">
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    placeholder="Your Email" />
            </div>
            <div class="form-group">
                <select name="subject" id="subject" required>
                    <option value="">Select Subject</option>
                    <option value="support">Technical Support</option>
                    <option value="partnership">Partnership</option>
                    <option value="general">General Inquiry</option>
                </select>
            </div>
            <div class="form-group">
                <textarea
                    id="message"
                    name="message"
                    required
                    placeholder="Your Message"></textarea>
            </div>
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</section>

<section class="metrics-section" data-aos="fade-up">
    <div class="metrics-container">
        <div class="metric-item">
            <i class="fas fa-clock"></i>
            <span class="metric-value">24/7</span>
            <span class="metric-label">Support Available</span>
        </div>
        <div class="metric-item">
            <i class="fas fa-shield-alt"></i>
            <span class="metric-value">100%</span>
            <span class="metric-label">Secure Platform</span>
        </div>
        <div class="metric-item">
            <i class="fas fa-globe"></i>
            <span class="metric-value">Global</span>
            <span class="metric-label">Coverage</span>
        </div>
    </div>
</section>

<section class="cta-section" data-aos="zoom-in">
    <h2>Ready to Start Your Journey?</h2>
    <p>Join our community of innovators and investors today</p>
    <div class="cta-buttons">
        <a href="{{ url('/login') }}" class="cta-button primary">Get Started Now</a>
        <a href="#contact" class="cta-button secondary">Contact Us</a>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="{{ asset('js/index.js') }}"></script>
@endsection