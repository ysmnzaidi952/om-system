<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us — O&M HSIS</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <style>
    /* ============================================================
       ABOUT PAGE — Scoped Styles
       ============================================================ */

    /* ── PAGE HERO ── */
    .about-hero {
      min-height: 60vh;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 140px 48px 80px;
      background: #021615;
      position: relative;
      overflow: hidden;
    }

    .about-hero::before {
      content: '';
      position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 70% 60% at 80% 20%, rgba(14,165,160,0.08) 0%, transparent 60%),
        radial-gradient(ellipse 50% 70% at 10% 90%, rgba(14,165,160,0.05) 0%, transparent 50%);
    }

    .about-hero-grid {
      position: absolute; inset: 0; opacity: 0.03;
      background-image:
        linear-gradient(rgba(245,243,239,1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(245,243,239,1) 1px, transparent 1px);
      background-size: 60px 60px;
    }

    .about-hero-content {
      position: relative; z-index: 2;
      max-width: 900px;
    }

    .about-hero-content .section-label {
      margin-bottom: 20px;
    }

    .about-hero-content h1 {
      font-family: var(--font-display);
      font-size: clamp(52px, 7vw, 96px);
      line-height: 1; letter-spacing: -1px; text-transform: uppercase;
      color: var(--white);
      animation: fadeUp 0.9s ease both;
    }

    .about-hero-content h1 span {
      color: var(--accent);
    }

    .about-hero-sub {
      margin-top: 28px;
      font-size: 16px; font-weight: 300;
      color: rgba(245,243,239,0.65);
      max-width: 560px; line-height: 1.8;
      animation: fadeUp 0.9s 0.15s ease both;
    }

    .about-hero-stats {
      display: flex; gap: 48px; margin-top: 56px; flex-wrap: wrap;
      animation: fadeUp 0.9s 0.3s ease both;
      padding-top: 40px;
      border-top: 1px solid rgba(255,255,255,0.08);
    }

    .about-stat {
      border-left: 2px solid var(--accent);
      padding-left: 20px;
    }

    .about-stat-num {
      font-family: var(--font-display);
      font-size: 44px; line-height: 1;
      color: var(--white);
    }

    .about-stat-label {
      font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
      color: rgba(245,243,239,0.4); margin-top: 4px;
    }

    /* ── SECTION: BACKGROUND (dark teal) ── */
    .about-background {
      background: #031e1d;
      padding: 100px 48px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }

    .about-background-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
    }

    .about-text-block .section-label {
      margin-bottom: 20px;
    }

    .about-text-block h2 {
      font-family: var(--font-display);
      font-size: clamp(32px, 4vw, 52px);
      letter-spacing: 1px; text-transform: uppercase;
      line-height: 1.05; margin-bottom: 28px;
      color: var(--white);
    }

    .about-text-block h2 span {
      color: var(--accent);
    }

    .about-text-block p {
      font-size: 15px;
      color: rgba(245,243,239,0.65);
      line-height: 1.85;
      margin-bottom: 16px;
    }

    .about-text-block p strong {
      color: var(--white);
      font-weight: 500;
    }

    .about-visual-card {
      background: #042e2c;
      padding: 48px;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(14,165,160,0.12);
    }

    .about-visual-card::before {
      content: 'iBURUJ';
      position: absolute;
      bottom: -10px; right: -10px;
      font-family: var(--font-display);
      font-size: 80px;
      color: rgba(14,165,160,0.06);
      line-height: 1;
      letter-spacing: -2px;
      pointer-events: none;
    }

    .about-visual-card-label {
      font-size: 10px;
      letter-spacing: 3px; text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 20px;
    }

    .about-visual-card h3 {
      font-family: var(--font-display);
      font-size: 28px; letter-spacing: 1px; text-transform: uppercase;
      color: var(--white);
      margin-bottom: 20px;
      line-height: 1.1;
    }

    .about-visual-card p {
      font-size: 14px;
      color: rgba(245,243,239,0.6);
      line-height: 1.8;
      margin-bottom: 28px;
    }

    .about-card-detail {
      display: flex;
      flex-direction: column;
      gap: 12px;
      border-top: 1px solid rgba(255,255,255,0.06);
      padding-top: 24px;
    }

    .about-card-detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
    }

    .about-card-detail-row span:first-child {
      color: rgba(245,243,239,0.35);
      letter-spacing: 1px; text-transform: uppercase;
    }

    .about-card-detail-row span:last-child {
      color: var(--white);
      font-weight: 500;
    }

    /* ── SECTION: ROLE AT HSIS (teal mid) ── */
    .about-role {
      background: #0a5654;
      padding: 100px 48px;
    }

    .about-role-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .about-role-header {
      display: flex;
      gap: 80px;
      margin-bottom: 64px;
      flex-wrap: wrap;
    }

    .about-role-header .section-title {
      flex: 0 0 auto;
    }

    .about-role-intro {
      flex: 1; min-width: 260px;
      padding-top: 8px;
    }

    .about-role-intro p {
      font-size: 15px;
      color: rgba(255,255,255,0.7);
      line-height: 1.85;
    }

    .about-role-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
    }

    .about-role-card {
      background: #0d7872;
      padding: 40px 36px;
      position: relative;
      overflow: hidden;
      transition: transform 0.3s, background 0.3s;
    }

    .about-role-card:hover {
      transform: translateY(-4px);
      background: #0f8a84;
    }

    .about-role-card::after {
      content: '';
      position: absolute; bottom: 0; left: 0; right: 0;
      height: 2px;
      background: var(--accent);
      transform: scaleX(0); transform-origin: left;
      transition: transform 0.4s;
    }

    .about-role-card:hover::after {
      transform: scaleX(1);
    }

    .role-card-icon {
      font-size: 28px;
      margin-bottom: 20px;
      display: block;
    }

    .role-card-num {
      position: absolute;
      top: 20px; right: 24px;
      font-family: var(--font-display);
      font-size: 64px;
      color: rgba(245,243,239,0.04);
      line-height: 1;
    }

    .about-role-card h3 {
      font-family: var(--font-display);
      font-size: 18px; letter-spacing: 1px; text-transform: uppercase;
      color: var(--white);
      margin-bottom: 12px;
    }

    .about-role-card p {
      font-size: 13px;
      color: rgba(245,243,239,0.6);
      line-height: 1.7;
    }

    /* ── SECTION: TECHNOLOGY PARTNER (dark) ── */
    .about-partner {
      background: #021615;
      padding: 100px 48px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }

    .about-partner-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }

    .about-partner-visual {
      background: #042e2c;
      padding: 56px 48px;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(14,165,160,0.1);
      text-align: center;
    }

    .about-partner-visual::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        linear-gradient(rgba(14,165,160,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(14,165,160,0.04) 1px, transparent 1px);
      background-size: 30px 30px;
    }

    .partner-logo-text {
      font-family: var(--font-display);
      font-size: 48px;
      letter-spacing: 4px;
      color: var(--white);
      text-transform: uppercase;
      position: relative; z-index: 1;
      margin-bottom: 8px;
    }

    .partner-logo-sub {
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--accent);
      position: relative; z-index: 1;
      margin-bottom: 32px;
    }

    .partner-tag-row {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      justify-content: center;
      position: relative; z-index: 1;
    }

    .partner-tag {
      background: rgba(14,165,160,0.12);
      border: 1px solid rgba(14,165,160,0.2);
      color: var(--accent);
      font-size: 10px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 6px 14px;
    }

    /* ── SECTION: TENDER / CONTRACT INFO ── */
    .about-tender {
      background: #053a38;
      padding: 100px 48px;
    }

    .about-tender-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .about-tender-header {
      margin-bottom: 64px;
    }

    .tender-timeline {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
    }

    .tender-step {
      background: #0a5250;
      padding: 40px 36px;
      position: relative;
      overflow: hidden;
    }

    .tender-step-num {
      font-family: var(--font-display);
      font-size: 72px;
      color: rgba(14,165,160,0.08);
      line-height: 1;
      position: absolute;
      top: 20px; right: 20px;
    }

    .tender-step-tag {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 16px;
    }

    .tender-step h3 {
      font-family: var(--font-display);
      font-size: 22px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--white);
      margin-bottom: 12px;
    }

    .tender-step p {
      font-size: 13px;
      color: rgba(245,243,239,0.6);
      line-height: 1.75;
    }

    .tender-step-arrow {
      position: absolute;
      right: -1px; top: 50%;
      transform: translateY(-50%);
      width: 0; height: 0;
      border-top: 12px solid transparent;
      border-bottom: 12px solid transparent;
      border-left: 12px solid #053a38;
      z-index: 2;
    }

    .tender-step:last-child .tender-step-arrow {
      display: none;
    }

    /* ── SECTION: VALUES / COMMITMENT ── */
    .about-values {
      background: #031e1d;
      padding: 100px 48px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }

    .about-values-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .about-values-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1px;
      margin-top: 56px;
    }

    .about-value-item {
      background: #042e2c;
      padding: 40px 32px;
      transition: background 0.3s;
      position: relative;
      overflow: hidden;
    }

    .about-value-item:hover {
      background: #053a38;
    }

    .about-value-num {
      font-family: var(--font-display);
      font-size: 48px;
      color: var(--accent);
      opacity: 0.25;
      line-height: 1;
      margin-bottom: 20px;
    }

    .about-value-icon {
      font-size: 24px;
      margin-bottom: 16px;
      display: block;
    }

    .about-value-item h4 {
      font-family: var(--font-display);
      font-size: 18px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--white);
      margin-bottom: 10px;
    }

    .about-value-item p {
      font-size: 13px;
      color: rgba(245,243,239,0.5);
      line-height: 1.75;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 1024px) {
      .about-background-inner,
      .about-partner-inner { grid-template-columns: 1fr; gap: 40px; }
      .about-role-grid { grid-template-columns: repeat(2, 1fr); }
      .tender-timeline { grid-template-columns: 1fr; }
      .about-values-grid { grid-template-columns: repeat(2, 1fr); }
      .tender-step-arrow { display: none; }
    }

    @media (max-width: 768px) {
      .about-hero { padding: 120px 24px 60px; }
      .about-background,
      .about-role,
      .about-partner,
      .about-tender,
      .about-values { padding: 72px 24px; }
      .about-role-grid { grid-template-columns: 1fr; }
      .about-values-grid { grid-template-columns: 1fr 1fr; }
      .about-hero-stats { gap: 28px; }
      .about-role-header { gap: 32px; }
    }

    @media (max-width: 480px) {
      .about-values-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<!-- ═══════════════════════════════════════════
     NAVIGATION (same as index)
════════════════════════════════════════════════ -->
<nav id="navbar">
  <div class="nav-logo">
    <span>O&M HSIS</span>
  </div>
  <ul class="nav-links">
    <li><a href="{{ url('/') }}#hero">Home</a></li>
    <li><a href="{{ url('/') }}#about" class="active">About</a></li>
    <li><a href="{{ route('team') }}">Team</a></li>
    <li><a href="{{ url('/') }}#services">Solutions</a></li>
    <li><a href="{{ url('/') }}#products">Products</a></li>
    <li><a href="{{ url('/') }}#career">Career</a></li>
    <li><a href="{{ url('/') }}#cta">Contact</a></li>
  </ul>

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
  <a href="{{ url('/') }}" onclick="toggleMenu()">Home</a>
  <a href="{{ url('/') }}#services" onclick="toggleMenu()">Solutions</a>
  <a href="{{ url('/') }}#products" onclick="toggleMenu()">Products</a>
  <a href="{{ url('/') }}#cta" onclick="toggleMenu()">Contact</a>
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


<!-- ═══════════════════════════════════════════
     SECTION 1 — PAGE HERO
════════════════════════════════════════════════ -->
<section class="about-hero">
  <div class="about-hero-grid"></div>
  <div class="about-hero-content">
    <div class="section-label">Who We Are</div>
    <h1>ABOUT<br><span>O&M HSIS</span></h1>
    <p class="about-hero-sub">
      We are the Operations &amp; Maintenance team at Hospital Sultan Idris Shah (HSIS) Serdang —
      a dedicated on-site ICT team operating under Iburuj Network Sdn Bhd, ensuring uninterrupted
      delivery of critical hospital systems and services.
    </p>
    <div class="about-hero-stats">
      <div class="about-stat">
        <div class="about-stat-num">7+</div>
        <div class="about-stat-label">Years Iburuj Experience</div>
      </div>
      <div class="about-stat">
        <div class="about-stat-num">6</div>
        <div class="about-stat-label">Service Areas</div>
      </div>
      <div class="about-stat">
        <div class="about-stat-num">4</div>
        <div class="about-stat-label">Core Platforms</div>
      </div>
      <div class="about-stat">
        <div class="about-stat-num">3yr</div>
        <div class="about-stat-label">Tender Cycle</div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     SECTION 2 — OUR BACKGROUND (Iburuj)
════════════════════════════════════════════════ -->
<section class="about-background">
  <div class="about-background-inner">

    <div class="about-text-block">
      <div class="section-label">Our Background</div>
      <h2>POWERED BY<br><span>IBURUJ</span><br>NETWORK</h2>
      <p>
        The O&amp;M HSIS unit is operated by <strong>Iburuj Network Sdn Bhd</strong> — a total IT
        solutions provider headquartered in Cyberjaya, Malaysia, with over 7 years of experience
        delivering mission-critical ICT services to both government and corporate clients.
      </p>
      <p>
        Iburuj holds the Operations &amp; Maintenance tender for Hospital Sultan Idris Shah (HSIS)
        in Serdang, Selangor. As the appointed O&amp;M vendor, Iburuj deploys a dedicated on-site
        team to manage, maintain, and support the hospital's entire ICT infrastructure — from
        service desk and network to servers, databases, applications, and security systems.
      </p>
      <p>
        The tender operates on a <strong>3-year renewable cycle</strong>, and Iburuj has built a
        strong track record of successful government project delivery across multiple ministries
        and agencies including KKM, JPN, JPM, KPT, and more.
      </p>
    </div>

    <div class="about-visual-card">
      <div class="about-visual-card-label">Company Profile</div>
      <div style="position: relative; margin-bottom: 20px;">
        <h3>Iburuj Network<br>Sdn Bhd</h3>
        <img src="{{ asset('image/ibn.png') }}" alt="Iburuj Network"
          style="position: absolute; top: 0; right: 0; height: 64px; width: auto; object-fit: contain;">
      </div>
      <p>
        A certified total IT solutions provider with expertise in Network Infrastructure,
        Network Security, Data Centre Development, and Business Continuity — trusted by
        Malaysia's leading government agencies.
      </p>
      <div class="about-card-detail">
        <div class="about-card-detail-row">
          <span>Headquarters</span>
          <span>Cyberjaya, Selangor</span>
        </div>
        <div class="about-card-detail-row">
          <span>Contact</span>
          <span>+603-86991490</span>
        </div>
        <div class="about-card-detail-row">
          <span>Current Site</span>
          <span>HSIS, Serdang</span>
        </div>
        <div class="about-card-detail-row">
          <span>Tender Type</span>
          <span>Government O&M</span>
        </div>
        <div class="about-card-detail-row">
          <span>Cycle</span>
          <span>3-Year Renewable</span>
        </div>
      </div>
    </div>

  </div>
</section>


<!-- ═══════════════════════════════════════════
     SECTION 3 — OUR ROLE AT HSIS
════════════════════════════════════════════════ -->
<section class="about-role">
  <div class="about-role-inner">

    <div class="about-role-header">
      <div>
        <div class="section-label">What We Do On-Site</div>
        <div class="section-title">OUR ROLE<br>AT HSIS</div>
      </div>
      <div class="about-role-intro">
        <p>
          Our on-site team at Hospital Sultan Idris Shah operates as the frontline ICT support
          unit — responsible for maintaining system availability, resolving incidents, and ensuring
          all hospital platforms run reliably around the clock. We bridge the gap between
          hospital operations and the technology that powers them.
        </p>
      </div>
    </div>

    <div class="about-role-grid">

      <div class="about-role-card">
        <span class="role-card-icon">🖥</span>
        <div class="role-card-num">01</div>
        <h3>System & Application Support</h3>
        <p>
          Maintaining availability and performance of critical hospital applications including
          the e-HIS platform — diagnosing issues, restoring access, and coordinating fixes to
          minimise disruption to daily clinical operations.
        </p>
      </div>

      <div class="about-role-card">
        <span class="role-card-icon">🌐</span>
        <div class="role-card-num">02</div>
        <h3>Network Infrastructure</h3>
        <p>
          Managing LAN and Wi-Fi infrastructure across hospital facilities — troubleshooting
          connectivity issues, performing switch and port verification, and conducting preventive
          checks to ensure reliable network availability.
        </p>
      </div>

      <div class="about-role-card">
        <span class="role-card-icon">🗄</span>
        <div class="role-card-num">03</div>
        <h3>Server & Data Centre</h3>
        <p>
          Ensuring system stability through monitoring, routine maintenance, configuration
          support, and performance checks — coordinating recovery support for critical
          server and data centre services.
        </p>
      </div>

      <div class="about-role-card">
        <span class="role-card-icon">🛡</span>
        <div class="role-card-num">04</div>
        <h3>Security & Access Control</h3>
        <p>
          Supporting access control coordination, security monitoring, and incident response
          alignment to protect hospital systems, sensitive patient data, and maintain
          regulatory compliance.
        </p>
      </div>

      <div class="about-role-card">
        <span class="role-card-icon">🗃</span>
        <div class="role-card-num">05</div>
        <h3>Database Administration</h3>
        <p>
          Supporting database integrity and availability — assisting with access issues,
          performance checks, and coordination to keep operational data consistent and
          accessible across all hospital systems.
        </p>
      </div>

      <div class="about-role-card">
        <span class="role-card-icon">🎧</span>
        <div class="role-card-num">06</div>
        <h3>Service Desk & Helpdesk</h3>
        <p>
          First line support for incident logging, user assistance, basic troubleshooting,
          and escalation coordination — ensuring fast response times and clear tracking of
          all reported issues.
        </p>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     SECTION 4 — TECHNOLOGY PARTNER (Dedalus)
════════════════════════════════════════════════ -->
<section class="about-partner">
  <div class="about-partner-inner">

    <div class="about-partner-visual">
      <div style="margin-bottom: 28px; position: relative; z-index: 1;">
        <img src="{{ asset('image/adeahub.png') }}" alt="AdeaHub"
          style="height: 56px; width: auto; object-fit: contain; display: block; margin: 0 auto;">
      </div>
      <div class="partner-logo-sub">Powering Modern Healthcare</div>
      <div class="partner-tag-row">
        <span class="partner-tag">Hospital Info System</span>
        <span class="partner-tag">Digital Front Door</span>
        <span class="partner-tag">Interoperability</span>
        <span class="partner-tag">FHIR-Compliant</span>
        <span class="partner-tag">MySejahtera</span>
        <span class="partner-tag">Malaysia-Built</span>
      </div>
    </div>

    <div class="about-text-block">
      <div class="section-label">Technology Partner</div>
      <h2>POWERED BY<br><span>ADEAHUB</span><br>PLATFORM</h2>
      <p>
        The Hospital Information System (HIS) deployed at HSIS Serdang runs on
        <strong>AdeaHub</strong> — a Malaysia-based healthcare technology company
        dedicated to delivering modern, connected, and personalised healthcare at scale.
      </p>
      <p>
        AdeaHub is the team behind <strong>MySejahtera</strong>, Malaysia's national
        digital health app — recognised as the world's #1 COVID-19 app by Data.ai,
        serving millions of Malaysians across vaccinations, health screenings, and
        appointment management.
      </p>
      <p>
        Their HIS platform provides the foundation for patient and workflow management,
        connected clinical systems, and revenue cycle management — and our O&amp;M team
        is responsible for the day-to-day maintenance, support, and operational continuity
        of this platform at HSIS, ensuring clinical workflows remain stable and available
        for hospital staff at all times.
      </p>
    </div>

  </div>
</section>


<!-- ═══════════════════════════════════════════
     SECTION 5 — HOW THE TENDER WORKS
════════════════════════════════════════════════ -->
<section class="about-tender">
  <div class="about-tender-inner">

    <div class="about-tender-header">
      <div class="section-label">How It Works</div>
      <div class="section-title">THE O&M<br>CONTRACT MODEL</div>
      <p class="section-desc">
        The O&amp;M services at HSIS operate under a structured government tender framework —
        ensuring accountability, continuity, and quality of ICT services delivered to the hospital.
      </p>
    </div>

    <div class="tender-timeline">

      <div class="tender-step">
        <div class="tender-step-num">01</div>
        <div class="tender-step-tag">Government Tender</div>
        <h3>Open Tender<br>Process</h3>
        <p>
          KKM (Ministry of Health Malaysia) opens a competitive tender for O&amp;M services
          at HSIS every 3 years. Qualified IT vendors submit proposals covering service
          scope, team capacity, and technical expertise.
        </p>
        <div class="tender-step-arrow"></div>
      </div>

      <div class="tender-step">
        <div class="tender-step-num">02</div>
        <div class="tender-step-tag">Vendor Appointment</div>
        <h3>Iburuj Network<br>Appointed</h3>
        <p>
          Iburuj Network Sdn Bhd was awarded the current O&amp;M contract for HSIS Serdang —
          deploying a full on-site team of ICT professionals to manage all designated
          service areas within the hospital.
        </p>
        <div class="tender-step-arrow"></div>
      </div>

      <div class="tender-step">
        <div class="tender-step-num">03</div>
        <div class="tender-step-tag">Ongoing O&M</div>
        <h3>On-Site Team<br>Delivery</h3>
        <p>
          Our team operates daily within HSIS — managing systems, responding to incidents,
          maintaining infrastructure, and ensuring the hospital's ICT platforms stay reliable
          throughout the contract period.
        </p>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     SECTION 6 — VALUES / COMMITMENT
════════════════════════════════════════════════ -->
<section class="about-values">
  <div class="about-values-inner">
    <div class="section-label">Our Commitment</div>
    <div class="section-title">WHAT WE<br>STAND FOR</div>

    <div class="about-values-grid">

      <div class="about-value-item">
        <div class="about-value-num">01</div>
        <h4>Reliability</h4>
        <p>
          Hospital systems cannot afford downtime. We operate with a preventive-first
          mindset — monitoring, maintaining, and acting fast to keep all platforms
          running without disruption.
        </p>
      </div>

      <div class="about-value-item">
        <div class="about-value-num">02</div>
        <h4>Security</h4>
        <p>
          Patient data and clinical systems are sensitive. We maintain strict access
          controls, support security monitoring, and align with hospital compliance
          requirements at every level.
        </p>
      </div>

      <div class="about-value-item">
        <div class="about-value-num">03</div>
        <h4>Responsiveness</h4>
        <p>
          When issues arise, speed matters. Our on-site presence means faster response
          times, direct coordination with hospital staff, and quicker resolution of
          critical incidents.
        </p>
      </div>

      <div class="about-value-item">
        <div class="about-value-num">04</div>
        <h4>Continuity</h4>
        <p>
          We are committed to ensuring seamless service delivery throughout the contract
          period — maintaining institutional knowledge, documentation, and operational
          standards regardless of personnel changes.
        </p>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     CTA SECTION
════════════════════════════════════════════════ -->
<section id="cta">
  <div class="section-label">Let's Dive In</div>
  <div class="section-title">READY TO<br>GET STARTED?</div>
  <p>Schedule a call with one of our Commercial Advisors, and see how we can help simplify and grow your business.</p>
  <a href="{{ url('/') }}#cta" class="btn-dark">Contact Us</a>
</section>


<!-- ═══════════════════════════════════════════
     FOOTER (same as index)
════════════════════════════════════════════════ -->
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
        <li><a href="{{ url('/') }}#services">Customer Support &amp; Service Desk</a></li>
        <li><a href="{{ url('/') }}#services">Application Support</a></li>
        <li><a href="{{ url('/') }}#services">System &amp; Server Support</a></li>
        <li><a href="{{ url('/') }}#services">Network Infrastructure Support</a></li>
        <li><a href="{{ url('/') }}#services">Database Administration</a></li>
        <li><a href="{{ url('/') }}#services">Security &amp; Access Management</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h5>Platforms</h5>
      <ul>
        <li><a href="http://10.37.237.15/HIS/eSM/jsp/login.jsp">Hospital Information System (HIS)</a></li>
        <li><a href="{{ url('/') }}#products">Server &amp; Data Centre Operations</a></li>
        <li><a href="{{ url('/') }}#products">Network &amp; Communication Services</a></li>
        <li><a href="{{ url('/') }}#products">Security &amp; Access Management</a></li>
      </ul>
      <br>
      <h5>Company</h5>
      <ul>
        <li><a href="{{ url('/about') }}">About</a></li>
        <li><a href="{{ route('team') }}">Team</a></li>
        <li><a href="{{ url('/') }}#career">Career</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h5>Contact</h5>
      <div class="footer-address">
        <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="5e373038311e373c2b2c2b34703d3133">[email&#160;protected]</a></p>
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


<!-- ═══════════════════════════════════════════
     SCRIPTS
════════════════════════════════════════════════ -->
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
  // Nav scroll effect
  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (nav) {
      nav.style.padding = window.scrollY > 60 ? '12px 48px' : '20px 48px';
    }
  });

  // Mobile menu toggle
  function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('open');
    document.body.style.overflow =
      document.getElementById('mobileMenu').classList.contains('open') ? 'hidden' : '';
  }

  // Scroll reveal
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll(
    '.about-role-card, .about-value-item, .tender-step, .about-visual-card, .about-partner-visual'
  ).forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(24px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e){
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
</script>

</body>
</html>
