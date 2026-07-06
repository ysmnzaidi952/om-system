<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>O&M-HSIS</title>
  <!-- Fonts loaded via @import in styles.css -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <style>
    /* Uniform logo container — all logos same box size */
    .client-card-logo-wrap {
      width: 80px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
    }

    .client-card-logo {
      max-width: 80px;
      max-height: 60px;
      width: auto;
      height: auto;
      object-fit: contain;
      display: block;
    }

    /* ── KKM ── */
    .cc-kkm .client-card-logo-wrap { width: 80px;  height: 60px; }
    .cc-kkm .client-card-logo      { max-width: 80px;  max-height: 60px; }

    /* ── KPM ── */
    .cc-kpm .client-card-logo-wrap { width: 110px; height: 80px; }
    .cc-kpm .client-card-logo      { max-width: 110px; max-height: 80px; }

    /* ── KPT ── */
    .cc-kpt .client-card-logo-wrap { width: 110px; height: 80px; }
    .cc-kpt .client-card-logo      { max-width: 110px; max-height: 80px; }

    /* ── JPM ── */
    .cc-jpm .client-card-logo-wrap { width: 110px; height: 80px; }
    .cc-jpm .client-card-logo      { max-width: 110px; max-height: 80px; }

    /* ── HERO VIDEO ── */
    .hero-video-bg {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      z-index: 0;
      pointer-events: none;
    }
  </style>
</head>
<body>

<!-- NAVIGATION -->
<nav id="navbar">
  <div class="nav-logo">
    <span>O&M HSIS</span>
  </div>
  <ul class="nav-links">
    <li><a href="#hero">Home</a></li>
    <li><a href="{{ route('about') }}">About</a></li>
    <li><a href="{{ route('team') }}">Team</a></li>
    <li><a href="#services">Solutions</a></li>
    <li><a href="#products">Products</a></li>
    <li><a href="#career">Career</a></li>
    <li><a href="#cta">Contact</a></li>
  </ul>

  {{-- Auth buttons — top right --}}
  <div class="nav-login">
    @auth
      <span class="nav-user">Hi, <strong>{{ Auth::user()->name }}</strong></span>
      @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">Dashboard</a>
      @else
        <a href="{{ route('staff.dashboard') }}" class="btn-dashboard">Dashboard</a>
      @endif
      <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
      </form>
    @else
      <a href="{{ route('login.show') }}" class="btn-login">Login</a>
    @endauth
  </div>

  <div class="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <button class="close-menu" onclick="toggleMenu()">✕</button>
  <a href="#hero" onclick="toggleMenu()">Home</a>
  <a href="#services" onclick="toggleMenu()">Solutions</a>
  <a href="#products" onclick="toggleMenu()">Products</a>
  <a href="#cta" onclick="toggleMenu()">Contact</a>
  @auth
    @if(Auth::user()->role === 'admin')
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    @else
      <a href="{{ route('staff.dashboard') }}">Dashboard</a>
    @endif
  @else
    <a href="{{ route('login.show') }}" style="color: var(--accent);">Login</a>
  @endauth
</div>

<!-- HERO -->
<section class="hero" id="hero">
  <video class="hero-video-bg" autoplay muted loop playsinline>
    <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
  </video>
  {{-- <div class="hero-grid"></div> --}}
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">HOSPITAL SERDANG SULTAN IDRIS SHAH</div>
    <h1>OPERATION &<br><span>MAINTENANCE</span></h1>
    <p class="hero-sub">Dedicated ICT Operations & Maintenance team keeping Hospital Sultan Idris Shah's critical systems running — reliably, securely, every day.</p>
    <div class="hero-actions">
      <a href="#services" class="btn-primary">Explore Solutions</a>
      <a href="#cta" class="btn-outline">Get in Touch</a>
    </div>
  </div>
  <div class="scroll-indicator">
    <span>Scroll</span>
    <div class="scroll-line"></div>
  </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="services-header">
    <div>
      <div class="section-label">What We Do</div>
      <div class="section-title">SERVICE<br>SOLUTIONS</div>
    </div>
    <div class="services-intro">
      <p>
        We deliver end-to-end Operations &amp; Maintenance (O&amp;M) services to keep Hospital Sultan Idris Shah (HSIS) running reliably — from frontline support to specialised technical teams.
        <br><br>
        Our focus is simple: stable systems, secure connectivity, and minimal downtime for critical hospital operations.
      </p>
    </div>
  </div>

  <div class="services-grid">
    <!-- Customer Support (Helpdesk) -->
    <div class="service-card svc-data">
      <div class="service-card-img"><img src="{{ asset('image/services/helpdesk.jpg') }}" alt="svc-data" class="svc-img"></div>
      <div class="service-card-overlay"></div>
      <div class="service-card-content">
        <h3>Customer Support &amp; Service Desk</h3>
        <p>First line support for incident logging, user assistance, basic troubleshooting, and escalation coordination to ensure fast response and clear tracking.</p>
        <a href="#cta" class="service-link">Request Support</a>
      </div>
    </div>

    <!-- Application Support -->
    <div class="service-card svc-dm">
      <div class="service-card-img"><img src="{{ asset('image/services/application.jpeg') }}" alt="svc-dm" class="svc-img"></div>
      <div class="service-card-overlay"></div>
      <div class="service-card-content">
        <h3>Application Support</h3>
        <p>Support for hospital applications and user workflows — diagnosing issues, restoring access, and coordinating fixes to reduce disruptions to daily operations.</p>
        <a href="#cta" class="service-link">Get Assistance</a>
      </div>
    </div>

    <!-- System Support -->
    <div class="service-card svc-palm">
      <div class="service-card-img"><img src="{{ asset('image/services/system.jpg') }}" alt="svc-palm" class="svc-img"></div>
      <div class="service-card-overlay"></div>
      <div class="service-card-content">
        <h3>System &amp; Server Support</h3>
        <p>System-level operations to keep services stable — monitoring, configuration support, performance checks, and troubleshooting for server or system-related issues.</p>
        <a href="#cta" class="service-link">Report an Issue</a>
      </div>
    </div>

    <!-- Network Support -->
    <div class="service-card svc-survey">
      <div class="service-card-img"><img src="{{ asset('image/services/network.jpg') }}" alt="svc-survey" class="svc-img"></div>
      <div class="service-card-overlay"></div>
      <div class="service-card-content">
        <h3>Network Infrastructure Support</h3>
        <p>LAN/Wi-Fi troubleshooting, switch and port verification, connectivity restoration, and preventive checks to ensure secure and reliable network availability.</p>
        <a href="#cta" class="service-link">Network Help</a>
      </div>
    </div>

    <!-- Database Support -->
    <div class="service-card svc-system">
      <div class="service-card-img"><img src="{{ asset('image/services/database.jpg') }}" alt="svc-system" class="svc-img"></div>
      <div class="service-card-overlay"></div>
      <div class="service-card-content">
        <h3>Database Administration</h3>
        <p>Database integrity and availability support — assisting with access issues, performance checks, and coordination to keep operational data consistent and accessible.</p>
        <a href="#cta" class="service-link">DB Support</a>
      </div>
    </div>

    <!-- Security Support -->
    <div class="service-card svc-web">
      <div class="service-card-img"><img src="{{ asset('image/services/security.jpg') }}" alt="svc-web" class="svc-img"></div>
      <div class="service-card-overlay"></div>
      <div class="service-card-content">
        <h3>Security &amp; Access Control</h3>
        <p>Security monitoring support, access control coordination, and incident response alignment to protect hospital systems and maintain compliance.</p>
        <a href="#cta" class="service-link">Security Support</a>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCTS -->
<section id="products">
  <div class="section-label">What We Manage</div>
  <div class="section-title">OPERATIONAL<br>PLATFORMS</div>
  <p class="section-desc">
    Our Operations &amp; Maintenance scope covers the key platforms and infrastructure that keep HSIS services running — ensuring availability, performance, and continuity across clinical and administrative operations.
  </p>

  <div class="products-grid">
    <!-- 01 Clinical Systems -->
    <div class="product-card">
      <div class="product-num">01</div>
      <div class="product-tag">Healthcare Platform</div>
      <h3>Hospital Information System (e-HIS)</h3>
      <p>
        Supports core hospital workflows such as patient registration, clinical operations, and service delivery across departments with minimal disruption.
      </p>
      <a href="#cta" class="product-link">Get Support →</a>
    </div>

    <!-- 02 Infrastructure -->
    <div class="product-card">
      <div class="product-num">02</div>
      <div class="product-tag">Core Infrastructure</div>
      <h3>Server &amp; Data Centre Operations</h3>
      <p>
        Ensures system stability through monitoring, routine maintenance, performance checks, and coordinated recovery support for critical services.
      </p>
      <a href="#cta" class="product-link">Report an Issue →</a>
    </div>

    <!-- 03 Network -->
    <div class="product-card">
      <div class="product-num">03</div>
      <div class="product-tag">Connectivity</div>
      <h3>Network &amp; Communication Services</h3>
      <p>
        Maintains reliable LAN and Wi-Fi connectivity, supports troubleshooting, and conducts preventive checks to minimise downtime in clinical areas.
      </p>
      <a href="#cta" class="product-link">Request Network Help →</a>
    </div>

    <!-- 04 Security -->
    <div class="product-card">
      <div class="product-num">04</div>
      <div class="product-tag">Protection</div>
      <h3>Security &amp; Access Management</h3>
      <p>
        Supports access control coordination, security monitoring, and incident handling alignment to protect hospital systems and sensitive information.
      </p>
      <a href="#cta" class="product-link">Security Support →</a>
    </div>
  </div>
</section>

<!-- CLIENTS MARQUEE -->
<section id="clients">
  <div class="clients-header">
    <div class="section-label">Our Track Record</div>
    <div class="section-title">GOVERNMENT<br>PROJECT EXPERIENCE</div>
    <p>
      We support mission-critical ICT operations across ministries and agencies — covering hospital information systems, data centres, networks, security, servers, and comprehensive maintenance services.
    </p>
  </div>

  <div class="marquee-wrapper">
    <div class="marquee-track">

      <!-- First set -->
      <div class="client-card cc-kkm">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kkm.png') }}" alt="KKM" class="client-card-logo"></div>
        <h4>KKM</h4>
        <span>HIS Upgrade &amp; O&amp;M Support</span>
      </div>

      <div class="client-card cc-agc">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/agc.png') }}" alt="AGC" class="client-card-logo"></div>
        <h4>AGC</h4>
        <span>Green Data Centre Preservation</span>
      </div>

      <div class="client-card cc-jpn">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jpn.png') }}" alt="JPN" class="client-card-logo"></div>
        <h4>JPN</h4>
        <span>Hardware Maintenance &amp; Network Security</span>
      </div>

      <div class="client-card cc-jim">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jim.png') }}" alt="JIM" class="client-card-logo"></div>
        <h4>JIM</h4>
        <span>Network Infrastructure &amp; ICT Security (Data Centre)</span>
      </div>

      <div class="client-card cc-kpdnhep">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kpdn.png') }}" alt="KPDNHEP" class="client-card-logo"></div>
        <h4>KPDNHEP</h4>
        <span>Maintenance &amp; Monitoring (Hardware &amp; Software)</span>
      </div>

      <div class="client-card cc-jdn">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jdn.png') }}" alt="JDN" class="client-card-logo"></div>
        <h4>JDN</h4>
        <span>Comprehensive ICT Support for PDSA</span>
      </div>

      <div class="client-card cc-kpm">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kpm.png') }}" alt="KPM" class="client-card-logo"></div>
        <h4>KPM</h4>
        <span>Data Centre Hardware/Software Upgrade (Private Cloud)</span>
      </div>

      <div class="client-card cc-kpt">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kpt.png') }}" alt="KPT" class="client-card-logo"></div>
        <h4>KPT</h4>
        <span>MYREN Network Operations &amp; Maintenance</span>
      </div>

      <div class="client-card cc-jpm">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jpm.png') }}" alt="JPM" class="client-card-logo"></div>
        <h4>JPM</h4>
        <span>Server &amp; Storage Infrastructure Services</span>
      </div>

      <!-- Duplicate for infinite loop -->
      <div class="client-card cc-kkm">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kkm.png') }}" alt="KKM" class="client-card-logo"></div>
        <h4>KKM</h4>
        <span>HIS Upgrade &amp; O&amp;M Support</span>
      </div>

      <div class="client-card cc-agc">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/agc.png') }}" alt="AGC" class="client-card-logo"></div>
        <h4>AGC</h4>
        <span>Green Data Centre Preservation</span>
      </div>

      <div class="client-card cc-jpn">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jpn.png') }}" alt="JPN" class="client-card-logo"></div>
        <h4>JPN</h4>
        <span>Hardware Maintenance &amp; Network Security</span>
      </div>

      <div class="client-card cc-jim">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jim.png') }}" alt="JIM" class="client-card-logo"></div>
        <h4>JIM</h4>
        <span>Network Infrastructure &amp; ICT Security (Data Centre)</span>
      </div>

      <div class="client-card cc-kpdnhep">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kpdn.png') }}" alt="KPDNHEP" class="client-card-logo"></div>
        <h4>KPDNHEP</h4>
        <span>Maintenance &amp; Monitoring (Hardware &amp; Software)</span>
      </div>

      <div class="client-card cc-jdn">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jdn.png') }}" alt="JDN" class="client-card-logo"></div>
        <h4>JDN</h4>
        <span>Comprehensive ICT Support for PDSA</span>
      </div>

      <div class="client-card cc-kpm">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kpm.png') }}" alt="KPM" class="client-card-logo"></div>
        <h4>KPM</h4>
        <span>Data Centre Hardware/Software Upgrade (Private Cloud)</span>
      </div>

      <div class="client-card cc-kpt">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/kpt.png') }}" alt="KPT" class="client-card-logo"></div>
        <h4>KPT</h4>
        <span>MYREN Network Operations &amp; Maintenance</span>
      </div>

      <div class="client-card cc-jpm">
        <div class="client-card-bg"></div>
        <div class="client-card-logo-wrap"><img src="{{ asset('image/jpm.png') }}" alt="JPM" class="client-card-logo"></div>
        <h4>JPM</h4>
        <span>Server &amp; Storage Infrastructure Services</span>
      </div>

    </div>
  </div>
</section>

<!-- CTA -->
<section id="cta">
  <div class="section-label">Let's Dive In</div>
  <div class="section-title">READY TO<br>GET STARTED?</div>
  <p>Schedule a call with one of our Commercial Advisors, and see how we can help simplify and grow your business.</p>
  <a href="#" class="btn-dark">Contact Us</a>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <div class="logo-text">O&amp;M HSIS</div>
      <p>
        OPERATIONS &amp; MAINTENANCE SERVICES<br>
        FOR CRITICAL HOSPITAL ICT PLATFORMS<br><br>
        2026 O&amp;M HSIS
      </p>

      <div class="footer-social">
        <a href="#" target="_blank" aria-label="Facebook">f</a>
        <a href="#" target="_blank" aria-label="Twitter">t</a>
        <a href="#" target="_blank" aria-label="Instagram">ig</a>
        <a href="#" target="_blank" aria-label="LinkedIn">in</a>
      </div>
    </div>

    <div class="footer-col">
      <h5>Services</h5>
      <ul>
        <li><a href="#services">Customer Support &amp; Service Desk</a></li>
        <li><a href="#services">Application Support</a></li>
        <li><a href="#services">System &amp; Server Support</a></li>
        <li><a href="#services">Network Infrastructure Support</a></li>
        <li><a href="#services">Database Administration</a></li>
        <li><a href="#services">Security &amp; Access Management</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h5>Platforms</h5>
      <ul>
        <li><a href="http://10.37.237.15/HIS/eSM/jsp/login.jsp">Hospital Information System (HIS)</a></li>
        <li><a href="#products">Server &amp; Data Centre Operations</a></li>
        <li><a href="#products">Network &amp; Communication Services</a></li>
        <li><a href="#products">Security &amp; Access Management</a></li>
      </ul>

      <br>

      <h5>Company</h5>
      <ul>
        <li><a href="#about">About</a></li>
        <li><a href="#team">Team</a></li>
        <li><a href="#career">Career</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h5>Contact</h5>
      <div class="footer-address">
        <p>
          <a href="/cdn-cgi/l/email-protection#c2b1b7b2b2adb0b682adafaab1abb1eca1adaf"><span class="__cf_email__" data-cfemail="364543464659444276595b5e455f451855595b">[email&#160;protected]</span></a>
        </p>
        <br>
        <p>
          Hospital Sultan Idris Shah (HSIS), Serdang<br>
          Jalan Puchong, 43000 Kajang, Selangor<br>
          Malaysia
        </p>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2026 O&amp;M HSIS. All rights reserved.</p>
    <a href="#">Privacy Policy</a>
  </div>
</footer>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>

<script>
  function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('open');
    document.body.style.overflow =
      document.getElementById('mobileMenu').classList.contains('open')
        ? 'hidden'
        : '';
  }

  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    nav.style.padding = window.scrollY > 60 ? '12px 48px' : '20px 48px';
  });

  const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  document.querySelectorAll('.service-card, .product-card, .section-title, .section-label')
    .forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(24px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });

  document.querySelectorAll('a[href^="#"]').f
