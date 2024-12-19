<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About - Auxiliare</title>
  <!-- Add Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon_io/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon_io/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon_io/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('assets/favicon_io/site.webmanifest') }}">
  <!-- Existing CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="{{asset('css/about.css')}}" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
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

  <main>
    <section class="hero-section">
      <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="animate-text">About Auxiliare</h1>
        <p class="hero-text">Bridging innovation with opportunity</p>
      </div>
      <div class="scroll-indicator">
        <div class="mouse"></div>
        <p>Scroll to explore</p>
      </div>
    </section>

    <section class="mission-section">
      <div class="container">
        <h2 data-aos="fade-up" data-aos-duration="800">Our Mission</h2>
        <p data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
          Auxiliare is committed to bridging the innovation divide by
          connecting startups, investors, and academic research. Our platform
          facilitates the journey from idea to market, fostering an
          environment where entrepreneurial spirit thrives through
          collaboration and investment.
        </p>
      </div>
    </section>

    <section class="offerings-section">
      <div class="container">
        <h2 data-aos="fade-up">What We Offer</h2>
        <div class="offerings-grid">
          <div class="offering-card" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-lightbulb"></i>
            <h3>For Entrepreneurs</h3>
            <p>Access to investors, mentorship, and scaling tools.</p>
          </div>
          <div class="offering-card" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-chart-line"></i>
            <h3>For Investors</h3>
            <p>
              Tools for discovering, evaluating, and investing in startups
              using advanced matching algorithms.
            </p>
          </div>
          <div class="offering-card" data-aos="fade-up" data-aos-delay="100">
            <i class="fas fa-microscope"></i>
            <h3>For Researchers</h3>
            <p>
              Opportunities to commercialize academic research by linking with
              market needs.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="team-section">
      <div class="container">
        <h2 data-aos="fade-up">Meet Our Team</h2>
        <div class="team-grid">
          <div class="team-member team-leader">
            <h3>Marc Niño Christopher P. Ocampo</h3>
            <p>Course: BSIT</p>
            <p>Role: Leader</p>
            <div class="contribution">
              <p>Project Management</p>
              <p>Front-end Development</p>
              <p>Back-end Development</p>
              <p>Documentation</p>
              <p>React-Native Development</p>
              <p>Researcher</p>
            </div>
            <a href="mailto:2200534@ub.edu.ph">2200534@ub.edu.ph</a>
          </div>
          <div class="team-member">
            <h3>Dawn Emmanuel U. Aguila</h3>
            <p>Course: BSIT</p>
            <p>Role: Vice Leader</p>
            <div class="contribution">
              <p>Database Design</p>
              <p>Back-end Development</p>
              <p>System Architecture</p>
            </div>
            <a href="mailto:2102479@ub.edu.ph">2102479@ub.edu.ph</a>
          </div>
          <div class="team-member">
            <h3>Bryan K. Soria</h3>
            <p>Course: BSIT</p>
            <p>Role: Member</p>
            <div class="contribution">
              <p>UI/UX Design</p>
              <p>Front-end Development</p>
              <p>Quality Assurance</p>
            </div>
            <a href="mailto:2201985@ub.edu.ph">2201985@ub.edu.ph</a>
          </div>
          <div class="team-member">
            <h3>Jimrei E. Ilao</h3>
            <p>Course: BSIT</p>
            <p>Role: Member</p>
            <div class="contribution">
              <p>API Integration</p>
              <p>Back-end Development</p>
              <p>Security Implementation</p>
            </div>
            <a href="mailto:1600072@ub.edu.ph">1600072@ub.edu.ph</a>
          </div>
          <div class="team-member">
            <h3>Eldrin A. Balda</h3>
            <p>Course: BSIT</p>
            <p>Role: Member</p>
            <div class="contribution">
              <p>Documentation</p>
              <p>Testing</p>
              <p>Frontend Support</p>
            </div>
            <a href="mailto:2200792@ub.edu.ph">2200792@ub.edu.ph</a>
          </div>
        </div>
      </div>
    </section>

    <section class="impact-section">
      <div class="container">
        <h2 data-aos="fade-down">Our Impact</h2>
        <p data-aos="fade-up" data-aos-delay="200">
          Auxiliare seeks to transform the funding and support of innovation,
          benefiting entrepreneurs, investors, educational institutions, and
          the public by nurturing an inclusive startup community.
        </p>
      </div>
    </section>

    <section class="join-section">
      <div class="container" data-aos="fade-up">
        <h2>Join Our Innovation Community</h2>
        <p>
          Ready to be part of something extraordinary? Join our platform to
          connect, collaborate, and create lasting impact in the world of
          innovation and entrepreneurship.
        </p>
        <a href="login.html" class="cta-button">Get Started Today</a>
      </div>
    </section>
  </main>

  <footer class="main-footer">
    <p>&copy; 2024 AUXILIARE | All Rights Reserved</p>
  </footer>

  <button id="scroll-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      offset: 200,
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
  <script src="{{ asset('js/mobile-menu.js') }}"></script>
</body>

</html>