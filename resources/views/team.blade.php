<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Team — O&M HSIS</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <style>
    .team-hero {
      min-height: 52vh;
      display: flex; flex-direction: column; justify-content: flex-end;
      padding: 140px 48px 72px;
      background: #021615;
      position: relative; overflow: hidden;
    }
    .team-hero::before {
      content: 'TEAM';
      position: absolute; top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      font-family: var(--font-display);
      font-size: clamp(120px, 20vw, 280px);
      font-weight: 700; letter-spacing: -4px;
      color: rgba(255,255,255,0.025);
      white-space: nowrap; pointer-events: none; line-height: 1;
    }
    .team-hero-grid {
      position: absolute; inset: 0; opacity: 0.03;
      background-image:
        linear-gradient(rgba(245,243,239,1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(245,243,239,1) 1px, transparent 1px);
      background-size: 60px 60px;
    }
    .team-hero-content { position: relative; z-index: 2; max-width: 900px; }
    .team-hero-content h1 {
      font-family: var(--font-display);
      font-size: clamp(52px, 7vw, 96px);
      line-height: 1; letter-spacing: -1px; text-transform: uppercase;
      color: var(--white); animation: fadeUp 0.9s ease both;
    }
    .team-hero-content h1 span { color: var(--accent); }
    .team-hero-sub {
      margin-top: 20px; font-size: 15px; font-weight: 300;
      color: rgba(245,243,239,0.55); max-width: 520px; line-height: 1.8;
      animation: fadeUp 0.9s 0.15s ease both;
    }
    .team-hero-stats {
      display: flex; gap: 40px; margin-top: 48px; flex-wrap: wrap;
      padding-top: 32px; border-top: 1px solid rgba(255,255,255,0.07);
      animation: fadeUp 0.9s 0.3s ease both;
    }
    .team-stat { border-left: 2px solid var(--accent); padding-left: 18px; }
    .team-stat-num { font-family: var(--font-display); font-size: 40px; line-height: 1; color: var(--white); }
    .team-stat-label { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: rgba(245,243,239,0.4); margin-top: 4px; }

    .team-section { padding: 48px 48px 0; }
    .team-section:last-of-type { padding-bottom: 80px; }

    .tier-label {
      font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
      color: rgba(245,243,243,0.4); margin-bottom: 14px;
      display: flex; align-items: center; gap: 14px;
    }
    .tier-label::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.07); }

    .team-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; }

    .member-card {
      position: relative; overflow: hidden;
      aspect-ratio: 3/4; cursor: default;
      transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .member-card:hover { transform: scale(1.02); z-index: 2; box-shadow: 0 20px 48px rgba(0,0,0,0.4); }

    .mc-bg { position: absolute; inset: 0; }
    /* Teal/dark palette */
    .mc-c1  { background: #0a5654; }
    .mc-c2  { background: #0f3460; }
    .mc-c3  { background: #0d7872; }
    .mc-c4  { background: #1a4a3a; }
    .mc-c5  { background: #2a4a5e; }
    .mc-c6  { background: #0a3a50; }
    .mc-c7  { background: #042e2c; }
    .mc-c8  { background: #0d4a40; }
    .mc-c9  { background: #163e6e; }
    .mc-c10 { background: #1a3550; }
    .mc-c11 { background: #0f4a28; }
    .mc-c12 { background: #0a1a30; }
    /* Pink/mauve — perempuan sahaja, scattered */
    .mc-c13 { background: #6b2d4a; }
    .mc-c14 { background: #7a3455; }
    .mc-c15 { background: #5c2640; }

    .member-photo {
      position: absolute; bottom: 0; left: 50%;
      transform: translateX(-50%);
      width: 100%; height: 100%;
      object-fit: contain; object-position: bottom center; display: block;
    }
    .member-hover {
      position: absolute; inset: 0;
      background: rgba(4, 46, 44, 0.90);
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 16px; text-align: center;
      opacity: 0; transition: opacity 0.3s ease;
    }
    .member-card:hover .member-hover { opacity: 1; }
    .mh-name {
      font-family: var(--font-display);
      font-size: clamp(13px, 1.4vw, 17px);
      font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
      color: #fff; line-height: 1.15; margin-bottom: 10px;
    }
    .mh-divider { width: 26px; height: 1px; background: var(--accent); margin: 0 auto 10px; }
    .mh-dept { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--accent); }

    @media (max-width: 1200px) { .team-grid { grid-template-columns: repeat(5, 1fr); } }
    @media (max-width: 900px)  { .team-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 768px)  {
      .team-hero { padding: 120px 24px 56px; }
      .team-section { padding-left: 24px; padding-right: 24px; }
      .team-grid { grid-template-columns: repeat(3, 1fr); }
      .team-hero-stats { gap: 24px; }
    }
    @media (max-width: 480px) { .team-grid { grid-template-columns: repeat(2, 1fr); } }
  </style>
</head>
<body>

<nav id="navbar">
  <div class="nav-logo"><span>O&M HSIS</span></div>
  <ul class="nav-links">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ route('about') }}">About</a></li>
    <li><a href="{{ route('team') }}" class="active">Team</a></li>
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
  <div class="hamburger" onclick="toggleMenu()"><span></span><span></span><span></span></div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <button class="close-menu" onclick="toggleMenu()">✕</button>
  <a href="{{ url('/') }}" onclick="toggleMenu()">Home</a>
  <a href="{{ route('about') }}" onclick="toggleMenu()">About</a>
  <a href="{{ route('team') }}" onclick="toggleMenu()">Team</a>
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


{{-- HERO --}}
<section class="team-hero">
  <div class="team-hero-grid"></div>
  <div class="team-hero-content">
    <div class="section-label">Our People</div>
    <h1>MEET THE<br><span>TEAM</span></h1>
    <p class="team-hero-sub">
      The dedicated on-site ICT professionals keeping Hospital Sultan Idris Shah
      running — every system, every day.
    </p>
    <div class="team-hero-stats">
      <div class="team-stat"><div class="team-stat-num">41</div><div class="team-stat-label">Team Members</div></div>
      <div class="team-stat"><div class="team-stat-num">6</div><div class="team-stat-label">Departments</div></div>
      <div class="team-stat"><div class="team-stat-num">4</div><div class="team-stat-label">Tiers</div></div>
      <div class="team-stat"><div class="team-stat-num">3yr</div><div class="team-stat-label">Contract Cycle</div></div>
    </div>
  </div>
</section>


{{-- ═══ TIER 1 — MANAGEMENT ═══ --}}
{{-- RAMYAN(L):c1  WAHIDAH(P):c13(pink) --}}
<div class="team-section">
  <div class="tier-label">Management</div>
  <div class="team-grid">

    <div class="member-card">
      <div class="mc-bg mc-c1"></div>
      <img src="{{ asset('image/transparent/yan.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">RAMYAN</div><div class="mh-divider"></div><div class="mh-dept">Project Manager</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c13"></div>{{-- WAHIDAH perempuan → pink --}}
      <img src="{{ asset('image/transparent/wawa.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">WAHIDAH</div><div class="mh-divider"></div><div class="mh-dept">Asst. Operation Manager</div></div>
    </div>

  </div>
</div>


{{-- ═══ TIER 2 — TEAM LEAD ═══ --}}
{{-- SHUHADA(P):c14(pink)  NATASHA(P):c3  ASYRAF(L):c5  FITRI(L):c6  ALIF(L):c7  FAKHRI(L):c8 --}}
<div class="team-section">
  <div class="tier-label">Team Lead</div>
  <div class="team-grid">

    <div class="member-card">
      <div class="mc-bg mc-c14"></div>{{-- SHUHADA perempuan → pink --}}
      <img src="{{ asset('image/transparent/shu.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">SHUHADA</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c3"></div>{{-- NATASHA perempuan → teal (tak semua pink) --}}
      <img src="{{ asset('image/transparent/tasha.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">NATASHA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c5"></div>
      <img src="{{ asset('image/transparent/acap.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ASYRAF</div><div class="mh-divider"></div><div class="mh-dept">System</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c6"></div>
      <img src="{{ asset('image/transparent/fitri.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">FITRI</div><div class="mh-divider"></div><div class="mh-dept">Security</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c7"></div>
      <img src="{{ asset('image/transparent/el.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ALIF</div><div class="mh-divider"></div><div class="mh-dept">Technical</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c8"></div>
      <img src="{{ asset('image/transparent/fakri.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">FAKHRI</div><div class="mh-divider"></div><div class="mh-dept">Network</div></div>
    </div>

  </div>
</div>


{{-- ═══ TIER 3 — LEADS CALL CENTER ═══ --}}
{{-- ILA(P):c13(pink wajib)  AIN(P):c4  ANUM(P):c9 --}}
<div class="team-section">
  <div class="tier-label">Leads (Call Center)</div>
  <div class="team-grid">

    <div class="member-card">
      <div class="mc-bg mc-c13"></div>{{-- ILA wajib pink --}}
      <img src="{{ asset('image/transparent/ila.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ILA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c4"></div>
      <img src="{{ asset('image/transparent/ain.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">AIN</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c9"></div>
      <img src="{{ asset('image/transparent/anum.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ANUM</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>

  </div>
</div>


{{-- ═══ TIER 4 — TEAM MEMBER ═══ --}}
{{--
  Colour plan (L=lelaki, P=perempuan, pink=c13/c14/c15 scatter untuk P):
  mawar(P):c2   asapis(L):c3  ridwan(L):c10  fiqah(P):c15(pink)  tikah(P):c5   zue(P):c6
  fazil(L):c7   nabilah(P):c8  biena(P):c14(pink)  ros(P):c9    anis(P):c11   irfan(L):c12
  diana(P):c1   yasmin(P):c15(pink)  bat(P):c2   mimi(P):c4   bella(P):c6   husna(P):c7   aliya(P):c8
  luqman(L):c3  mira(P):c13(pink)  iman(L):c5   muzakir(L):c10  aizat(L):c11  megat(L):c12  azree(L):c1
--}}
<div class="team-section">
  <div class="tier-label">Team Member</div>
  <div class="team-grid">

    {{-- Row 1 --}}
    <div class="member-card">
      <div class="mc-bg mc-c2"></div>
      <img src="{{ asset('image/transparent/mawar.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">MAWAR</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c3"></div>
      <img src="{{ asset('image/transparent/asapis.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">HAFIZ</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c10"></div>
      <img src="{{ asset('image/transparent/ridwan.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">RIDWAN</div><div class="mh-divider"></div><div class="mh-dept">System</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c15"></div>{{-- FIQAH perempuan → pink --}}
      <img src="{{ asset('image/transparent/fiqah.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">SYAFIQAH</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c5"></div>
      <img src="{{ asset('image/transparent/tikah.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ATIKAH</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c6"></div>
      <img src="{{ asset('image/transparent/zue.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ZULAIKHA</div><div class="mh-divider"></div><div class="mh-dept">Network</div></div>
    </div>

    {{-- Row 2 --}}
    <div class="member-card">
      <div class="mc-bg mc-c7"></div>
      <img src="{{ asset('image/transparent/fazil.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">FADHZIL</div><div class="mh-divider"></div><div class="mh-dept">Technical</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c8"></div>
      <img src="{{ asset('image/transparent/nabilah.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">NABILAH</div><div class="mh-divider"></div><div class="mh-dept">DBA System</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c14"></div>{{-- BIENA perempuan → pink --}}
      <img src="{{ asset('image/transparent/biena.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">SABRINA</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c9"></div>
      <img src="{{ asset('image/transparent/ros.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ROSLINA</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c11"></div>
      <img src="{{ asset('image/transparent/anis.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ANIS</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c12"></div>
      <img src="{{ asset('image/transparent/irfan.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">IRFAN</div><div class="mh-divider"></div><div class="mh-dept">Technical</div></div>
    </div>

    {{-- Row 3 --}}
    <div class="member-card">
      <div class="mc-bg mc-c1"></div>
      <img src="{{ asset('image/transparent/bat.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">BATRISYA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c6"></div>{{-- YASMIN perempuan → pink --}}
      <img src="{{ asset('image/transparent/yasmin.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">YASMIN</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c4"></div>
      <img src="{{ asset('image/transparent/diana.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">DIANA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c15"></div>
      <img src="{{ asset('image/transparent/mimi.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">SYAMIMI</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c3"></div>
      <img src="{{ asset('image/transparent/bella.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">BELLA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c8"></div>
      <img src="{{ asset('image/transparent/husna.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">HUSNA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c11"></div>
      <img src="{{ asset('image/transparent/aliya.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">ALIYA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>

    {{-- Row 4 --}}
    <div class="member-card">
      <div class="mc-bg mc-c7"></div>
      <img src="{{ asset('image/transparent/luqman.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">LUQMAN</div><div class="mh-divider"></div><div class="mh-dept">Technical</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c13"></div>{{-- MIRA perempuan → pink --}}
      <img src="{{ asset('image/transparent/mira.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">AMIRA</div><div class="mh-divider"></div><div class="mh-dept">Call Center</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c5"></div>
      <img src="{{ asset('image/transparent/iman.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">IMAN</div><div class="mh-divider"></div><div class="mh-dept">Technical</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c10"></div>
      <img src="{{ asset('image/transparent/muzakir.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">MUZAKIR</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c2"></div>
      <img src="{{ asset('image/transparent/aizat.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">AIZAT</div><div class="mh-divider"></div><div class="mh-dept">Application</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c12"></div>
      <img src="{{ asset('image/transparent/megat.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">MEGAT</div><div class="mh-divider"></div><div class="mh-dept">System</div></div>
    </div>
    <div class="member-card">
      <div class="mc-bg mc-c9"></div>
      <img src="{{ asset('image/transparent/azree.png') }}" alt="" class="member-photo">
      <div class="member-hover"><div class="mh-name">AZREE</div><div class="mh-divider"></div><div class="mh-dept">Technical</div></div>
    </div>

  </div>
</div>


<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <div class="logo-text">O&amp;M HSIS</div>
      <p>OPERATIONS &amp; MAINTENANCE SERVICES<br>FOR CRITICAL HOSPITAL ICT PLATFORMS<br><br>2026 O&amp;M HSIS</p>
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
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('team') }}">Team</a></li>
        <li><a href="{{ url('/') }}#career">Career</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h5>Contact</h5>
      <div class="footer-address">
        <p>om-hsis@iburuj.com.my</p>
        <br>
        <p>Hospital Sultan Idris Shah (HSIS), Serdang<br>Jalan Puchong, 43000 Kajang, Selangor<br>Malaysia</p>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2026 O&amp;M HSIS. All rights reserved.</p>
    <a href="#">Privacy Policy</a>
  </div>
</footer>

<script>
  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (nav) nav.style.padding = window.scrollY > 60 ? '12px 48px' : '20px 48px';
  });
  function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('open');
    document.body.style.overflow =
      document.getElementById('mobileMenu').classList.contains('open') ? 'hidden' : '';
  }
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.05, rootMargin: '0px 0px -30px 0px' });
  document.querySelectorAll('.member-card').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = `opacity 0.5s ease ${(i % 6) * 0.07}s, transform 0.5s ease ${(i % 6) * 0.07}s`;
    observer.observe(el);
  });
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
</script>

</body>
</html>
