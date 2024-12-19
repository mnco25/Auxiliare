<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pricing - Auxiliare</title>
  <!-- Add Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon_io/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon_io/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon_io/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('assets/favicon_io/site.webmanifest') }}">
  <!-- Existing CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

  <link rel="stylesheet" href="{{asset('css/pricing.css')}}" />
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
    <button class="mobile-nav-toggle" aria-label="Toggle navigation menu">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>
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

  <section class="hero-section" data-aos="fade-up">
    <h1>
      <span class="gradient-text">Innovation Starts Here</span>
      <span class="subheading">Choose the plan that powers your success</span>
    </h1>
  </section>

  <main class="pricing-section">
    <div class="toggle-container" data-aos="fade-up" data-aos-delay="200">
      <span id="monthly-label">Monthly</span>
      <label class="switch" aria-labelledby="monthly-label annual-label">
        <input
          type="checkbox"
          id="billing-toggle"
          aria-label="Toggle between monthly and annual billing" />
        <span class="slider"></span>
      </label>
      <span id="annual-label">Annual</span>
      <span class="discount-badge">Save up to 20%</span>
    </div>

    <div class="pricing-container">
      <!-- Basic Tier -->
      <div class="pricing-card" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header">
          <h2>Basic Tier</h2>
          <div class="price" data-monthly="0" data-annual="0">
            <span class="currency">₱</span>
            <span class="amount">0</span>
            <span class="period">/month</span>
          </div>
        </div>
        <ul>
          <li><i class="fas fa-check"></i> Access to basic features</li>
          <li><i class="fas fa-check"></i> Community forums</li>
          <li><i class="fas fa-check"></i> Limited support</li>
        </ul>
        <a href="login.html" class="cta-button">Get Started</a>
      </div>
      <!-- Startup Pro -->
      <div
        class="pricing-card popular"
        data-aos="fade-up"
        data-aos-delay="200">
        <div class="popular-badge">Most Popular</div>
        <div class="card-header">
          <h2>Startup Pro</h2>
          <div class="price" data-monthly="200" data-annual="160">
            <span class="currency">₱</span>
            <span class="amount">200</span>
            <span class="period">/month</span>
          </div>
        </div>
        <ul>
          <li><i class="fas fa-check"></i> Enhanced features for startups</li>
          <li><i class="fas fa-check"></i> Priority support</li>
          <li><i class="fas fa-check"></i> Access to webinars</li>
          <li><i class="fas fa-check"></i> Basic analytics tools</li>
        </ul>
        <a href="login.html" class="cta-button">Choose Plan</a>
      </div>
      <!-- Investor Basic -->
      <div class="pricing-card" data-aos="fade-up" data-aos-delay="300">
        <div class="card-header">
          <h2>Investor Basic</h2>
          <div class="price" data-monthly="400" data-annual="320">
            <span class="currency">₱</span>
            <span class="amount">400</span>
            <span class="period">/month</span>
          </div>
        </div>
        <ul>
          <li><i class="fas fa-check"></i> Investor toolkit</li>
          <li><i class="fas fa-check"></i> Basic market insights</li>
          <li><i class="fas fa-check"></i> Access to startup profiles</li>
          <li><i class="fas fa-check"></i> Standard support</li>
        </ul>
        <a href="login.html" class="cta-button">Choose Plan</a>
      </div>
      <!-- Investor Premium -->
      <div class="pricing-card" data-aos="fade-up" data-aos-delay="400">
        <div class="card-header">
          <h2>Investor Premium</h2>
          <div class="price" data-monthly="1000" data-annual="800">
            <span class="currency">₱</span>
            <span class="amount">1000</span>
            <span class="period">/month</span>
          </div>
        </div>
        <ul>
          <li><i class="fas fa-check"></i> Comprehensive market analysis</li>
          <li>
            <i class="fas fa-check"></i> Direct startup pitching opportunities
          </li>
          <li><i class="fas fa-check"></i> Premium support</li>
          <li><i class="fas fa-check"></i> Advanced analytics</li>
        </ul>
        <a href="login.html" class="cta-button">Choose Plan</a>
      </div>
      <!-- Enterprise/Institution -->
      <div class="pricing-card" data-aos="fade-up" data-aos-delay="500">
        <div class="card-header">
          <h2>Enterprise / Institution</h2>
          <div class="price" data-monthly="2000" data-annual="1600">
            <span class="currency">₱</span>
            <span class="amount">2000</span>
            <span class="period">/month</span>
          </div>
        </div>
        <ul>
          <li><i class="fas fa-check"></i> Full suite of services</li>
          <li><i class="fas fa-check"></i> Custom integrations</li>
          <li><i class="fas fa-check"></i> Dedicated account management</li>
          <li><i class="fas fa-check"></i> Extensive analytics</li>
          <li><i class="fas fa-check"></i> Priority access to events</li>
        </ul>
        <a href="contact.html" class="cta-button">Contact Us</a>
      </div>
    </div>
  </main>

  <section class="features-highlight" data-aos="fade-up">
    <div class="container">
      <h2>Why Choose Auxiliare?</h2>
      <div class="features-grid">
        <div class="feature-item">
          <i class="fas fa-shield-alt"></i>
          <h3>Secure Platform</h3>
          <p>Enterprise-grade security for your data and transactions</p>
        </div>
        <div class="feature-item">
          <i class="fas fa-headset"></i>
          <h3>24/7 Support</h3>
          <p>Dedicated support team ready to help you succeed</p>
        </div>
        <div class="feature-item">
          <i class="fas fa-sync"></i>
          <h3>Regular Updates</h3>
          <p>Continuous platform improvements and new features</p>
        </div>
      </div>
    </div>
  </section>

  <section class="faq-section" data-aos="fade-up">
    <div class="container">
      <h2>Frequently Asked Questions</h2>
      <div class="faq-container">
        <div class="faq-item">
          <button class="faq-button">
            <span>What payment methods do you accept?</span>
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="faq-content">
            <p>
              We accept all major credit cards, PayPal, and bank transfers.
              All transactions are secured with industry-standard encryption.
            </p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-button">
            <span>Can I switch plans later?</span>
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="faq-content">
            <p>
              Yes, you can upgrade or downgrade your plan at any time. Changes
              will be reflected in your next billing cycle.
            </p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-button">
            <span>Is there a free trial available?</span>
            <i class="fas fa-chevron-down"></i>
          </button>
          <div class="faq-content">
            <p>
              Yes, you can try our Basic plan for free to explore our
              platform's core features before committing to a paid plan.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="main-footer">
    <p>&copy; 2024 AUXILIARE | All Rights Reserved</p>
  </footer>

  <button id="scroll-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="{{ asset('js/mobile-menu.js') }}"></script>
  <script>
    AOS.init({
      once: true,
      offset: 200,
    });

    // Pricing toggle functionality
    const billingToggle = document.getElementById("billing-toggle");
    const priceElements = document.querySelectorAll(".price");
    const periodElements = document.querySelectorAll(".period");

    billingToggle.addEventListener("change", () => {
      const isAnnual = billingToggle.checked;

      priceElements.forEach((priceEl) => {
        const amount = priceEl.querySelector(".amount");
        const currentPrice = isAnnual ?
          priceEl.dataset.annual :
          priceEl.dataset.monthly;

        // Animate price change
        amount.style.transform = "translateY(-10px)";
        amount.style.opacity = "0";

        setTimeout(() => {
          amount.textContent = currentPrice;
          amount.style.transform = "translateY(0)";
          amount.style.opacity = "1";
        }, 200);
      });

      // Update period text
      periodElements.forEach((period) => {
        period.textContent = isAnnual ? "/month (billed annually)" : "/month";
      });
    });

    // FAQ functionality from index.html
    document.querySelectorAll(".faq-button").forEach((button) => {
      button.addEventListener("click", () => {
        const faqItem = button.parentElement;
        faqItem.classList.toggle("active");

        document.querySelectorAll(".faq-item").forEach((item) => {
          if (item !== faqItem) item.classList.remove("active");
        });
      });
    });

    // Add scroll to top functionality
    const scrollToTopBtn = document.getElementById("scroll-to-top");

    window.addEventListener("scroll", () => {
      if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add("show");
      } else {
        scrollToTopBtn.classList.remove("show");
      }
    });

    scrollToTopBtn.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  </script>
</body>

</html>