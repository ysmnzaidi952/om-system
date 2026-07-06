{{-- C:\laragon\www\om_system\resources\views\intern\dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Intern Dashboard | O&M HRCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --teal-dark:   #042e2c;
            --teal-base:   #0a5654;
            --teal-bright: #0EA5A0;
            --off-white:   #f0fafa;
            --text-main:   #0a2e2c;
            --text-muted:  #4a7a76;
            --border:      rgba(14,165,160,0.15);
            --shadow-sm:   0 4px 24px rgba(6,62,60,0.10);
            --shadow-md:   0 8px 32px rgba(6,62,60,0.15);
            --font:        'Poppins', sans-serif;
            --red:   #ef4444; --amber: #f59e0b;
            --green: #22c55e; --blue:  #3b82f6;
            --accent: #0EA5A0; --white: #ffffff;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--off-white); color: var(--text-main); font-size: 14px; line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        .dashboard-layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .dashboard-sidebar { width: 240px; min-height: 100vh; background: var(--teal-dark); border-right: 1px solid rgba(255,255,255,0.06); display: flex; flex-direction: column; flex-shrink: 0; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .sidebar-header { padding: 32px 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .sidebar-brand { font-size: 24px; font-weight: 700; letter-spacing: 3px; color: var(--accent); line-height: 1; margin-bottom: 10px; }
        .sidebar-role { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: rgba(245,243,239,0.35); margin-bottom: 4px; }
        .sidebar-user { font-size: 13px; font-weight: 500; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-menu { flex: 1; padding: 16px 0; }
        .sidebar-menu ul { list-style: none; margin: 0; padding: 0; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 12px; padding: 12px 24px; font-size: 13px; color: rgba(245,243,239,0.5); transition: all 0.2s; position: relative; text-decoration: none; }
        .sidebar-menu li a i { font-size: 13px; width: 16px; text-align: center; flex-shrink: 0; color: rgba(245,243,239,0.3); transition: color 0.2s; }
        .sidebar-menu li a:hover { color: var(--white); background: rgba(14,165,160,0.08); padding-left: 28px; }
        .sidebar-menu li a:hover i { color: var(--accent); }
        .sidebar-menu li.active a { color: var(--white); background: rgba(14,165,160,0.14); font-weight: 500; }
        .sidebar-menu li.active a::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--accent); border-radius: 0 2px 2px 0; }
        .sidebar-menu li.active a i { color: var(--accent); }
        .sidebar-logout { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.06); }
        .sidebar-logout a { color: rgba(245,243,239,0.3) !important; }
        .sidebar-logout a:hover { color: #f87171 !important; background: rgba(239,68,68,0.08) !important; padding-left: 28px; }
        .sidebar-logout a:hover i { color: #f87171 !important; }
        .dashboard-sidebar::-webkit-scrollbar { width: 4px; }
        .dashboard-sidebar::-webkit-scrollbar-thumb { background: rgba(14,165,160,0.2); border-radius: 2px; }

        /* MAIN */
        .dashboard-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-date { font-size: 11px; color: var(--text-muted); background: var(--off-white); border: 1px solid var(--border); padding: 5px 10px; border-radius: 6px; }
        .topbar-icon-btn { width: 34px; height: 34px; border-radius: 7px; background: var(--off-white); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); cursor: pointer; font-size: 13px; transition: all 0.2s; }
        .topbar-icon-btn:hover { border-color: var(--teal-bright); color: var(--teal-bright); }
        .page-content { padding: 24px 28px; flex: 1; background: var(--off-white); }
        .dashboard-header { margin-bottom: 20px; }
        .dashboard-header h2 { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .dashboard-header p { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .success-message { display: flex; align-items: center; gap: 10px; background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.25); border-left: 3px solid var(--green); padding: 11px 14px; border-radius: 8px; font-size: 13px; color: #166534; margin-bottom: 18px; }
        .warning-message { display: flex; align-items: flex-start; gap: 10px; background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.3); border-left: 3px solid var(--amber); padding: 11px 14px; border-radius: 8px; font-size: 13px; color: #92400e; margin-bottom: 18px; }
        .warning-message i { color: var(--amber); margin-top: 2px; flex-shrink: 0; }
        .warning-message a { color: #92400e; font-weight: 600; text-decoration: underline; }

        /* STATS */
        .top-stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card { background: #fff; border-radius: 10px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; background: rgba(14,165,160,0.1); color: var(--teal-bright); }
        .stat-icon.amber { background: rgba(245,158,11,0.1); color: var(--amber); }
        .stat-icon.blue  { background: rgba(59,130,246,0.1); color: var(--blue); }
        .stat-info h3 { font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px; }
        .stat-info h2 { font-size: 26px; font-weight: 700; color: var(--text-main); line-height: 1.2; letter-spacing: -0.5px; }
        .stat-info p { font-size: 11px; color: var(--text-muted); margin-top: 3px; }

        /* GRID + CALENDAR */
        .main-content-grid { display: grid; grid-template-columns: 1fr 320px; gap: 16px; }
        .calendar-container { background: #fff; border-radius: 10px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); overflow: hidden; }
        .mini-calendar-header { background: var(--teal-base); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between; }
        .mini-calendar-header h4 { font-size: 14px; font-weight: 600; color: #fff; margin: 0; }
        .mini-nav-btn { width: 30px; height: 30px; background: rgba(255,255,255,0.15); border: none; border-radius: 6px; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 11px; transition: background 0.2s; }
        .mini-nav-btn:hover { background: rgba(255,255,255,0.28); }
        .mini-calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
        .mini-weekday { text-align: center; font-size: 10px; font-weight: 600; color: var(--text-muted); letter-spacing: 0.5px; padding: 5px 0; }
        .mini-day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 500; border-radius: 7px; cursor: pointer; transition: all 0.15s; color: var(--text-main); position: relative; }
        .mini-day:not(.empty):hover { background: rgba(14,165,160,0.1); color: var(--teal-bright); }
        .mini-day.empty { color: rgba(0,0,0,0.15); cursor: default; }
        .mini-day.today { background: var(--teal-bright); color: #fff; font-weight: 700; box-shadow: 0 2px 8px rgba(14,165,160,0.4); }
        .mini-day.today:hover { background: var(--teal-bright); color: #fff; }
        .mini-day.has-leave { background: rgba(239,68,68,0.1); color: var(--red); font-weight: 600; }
        .mini-day.has-leave::after { content: ''; position: absolute; bottom: 3px; left: 50%; transform: translateX(-50%); width: 3px; height: 3px; background: var(--red); border-radius: 50%; }
        .mini-day.today.has-leave { background: linear-gradient(135deg, var(--teal-bright), var(--red)); color: #fff; }
        .event-dot { position: absolute; top: 3px; right: 3px; width: 6px; height: 6px; border-radius: 50%; }
        .mini-day.has-leave .event-dot { right: auto; left: 3px; }
        .calendar-footer-row { padding: 12px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .cal-legend { display: flex; gap: 14px; }
        .legend-item { display: flex; align-items: center; gap: 5px; font-size: 11px; color: var(--text-muted); }
        .legend-dot { width: 7px; height: 7px; border-radius: 50%; }
        .view-calendar-link { font-size: 12px; font-weight: 500; color: var(--teal-bright); display: flex; align-items: center; gap: 5px; transition: gap 0.2s; }
        .view-calendar-link:hover { gap: 9px; }

        /* WIDGETS */
        .right-sidebar-widgets { display: flex; flex-direction: column; gap: 16px; }
        .quick-link-widget, .calendar-info-widget { background: #fff; border-radius: 10px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); overflow: hidden; }
        .widget-title { font-size: 13px; font-weight: 600; color: var(--text-main); padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
        .widget-title i { color: var(--teal-bright); }
        .quick-links-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 14px; }
        .quick-link-btn { padding: 12px 8px; border-radius: 8px; background: var(--off-white); border: 1px solid var(--border); display: flex; flex-direction: column; align-items: center; gap: 7px; transition: all 0.2s; text-align: center; }
        .quick-link-btn i { font-size: 17px; color: var(--teal-bright); }
        .quick-link-btn span { font-size: 11px; color: var(--text-main); font-weight: 500; line-height: 1.3; }
        .quick-link-btn:hover { transform: translateY(-2px); background: var(--teal-bright); border-color: var(--teal-bright); box-shadow: 0 4px 12px rgba(14,165,160,0.3); }
        .quick-link-btn:hover i, .quick-link-btn:hover span { color: #fff; }
        .calendar-info-widget { min-height: 180px; }
        .calendar-info-content { padding: 14px; min-height: 160px; }
        .calendar-info-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 28px 12px; text-align: center; color: var(--text-muted); gap: 8px; }
        .calendar-info-empty i { font-size: 24px; opacity: 0.3; color: var(--teal-bright); }
        .calendar-info-empty p { font-size: 11px; }
        .selected-date-header { background: linear-gradient(135deg, var(--teal-base), var(--teal-bright)); color: #fff; padding: 10px 12px; border-radius: 7px; margin-bottom: 10px; font-size: 12px; font-weight: 600; text-align: center; }
        .leave-info-item, .event-info-item { padding: 9px 11px; border-radius: 6px; border-left: 3px solid; margin-bottom: 7px; }
        .leave-info-item { background: rgba(239,68,68,0.06); border-left-color: var(--red); }
        .leave-info-item strong, .event-info-item strong { display: block; font-size: 12px; color: var(--text-main); margin-bottom: 2px; }
        .leave-info-item small, .event-info-item small { font-size: 11px; color: var(--text-muted); }
        .leave-info-list h5, .event-info-list h5 { font-size: 10px; font-weight: 600; color: var(--teal-bright); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 7px; display: flex; align-items: center; gap: 5px; }
        .event-info-item.event-green  { background: rgba(34,197,94,0.08)  !important; border-left-color: #22c55e !important; }
        .event-info-item.event-yellow { background: rgba(251,191,36,0.08)  !important; border-left-color: #fbbf24 !important; }
        .event-info-item.event-orange { background: rgba(249,115,22,0.08)  !important; border-left-color: #f97316 !important; }
        .event-info-item.event-red    { background: rgba(239,68,68,0.08)   !important; border-left-color: #ef4444 !important; }
        .event-info-item.event-blue   { background: rgba(59,130,246,0.08)  !important; border-left-color: #3b82f6 !important; }
        .event-info-item.event-purple { background: rgba(168,85,247,0.08)  !important; border-left-color: #a855f7 !important; }
        .event-info-item.event-pink   { background: rgba(236,72,153,0.08)  !important; border-left-color: #ec4899 !important; }
        .event-dot-green { background: #22c55e; } .event-dot-yellow { background: #fbbf24; } .event-dot-orange { background: #f97316; }
        .event-dot-red   { background: #ef4444; } .event-dot-blue   { background: #3b82f6; } .event-dot-purple { background: #a855f7; } .event-dot-pink { background: #ec4899; }

        @media (max-width: 1200px) { .main-content-grid { grid-template-columns: 1fr; } .quick-links-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 1024px) { .dashboard-sidebar { width: 200px; } }
        @media (max-width: 768px)  { .top-stats-row { grid-template-columns: 1fr; } .quick-links-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>
<div class="dashboard-layout">

    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">O&M</div>
            <div class="sidebar-role">Intern Dashboard</div>
            <div class="sidebar-user">{{ Auth::user()->name }}</div>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <li class="{{ request()->routeIs('intern.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('intern.dashboard') }}"><i class="fas fa-home"></i><span>Dashboard</span></a>
                </li>
                <li class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <a href="{{ route('profile.show') }}"><i class="fas fa-user"></i><span>My Profile</span></a>
                </li>
                <li class="{{ request()->routeIs('intern.team-staff') ? 'active' : '' }}">
                    <a href="{{ route('intern.team-staff') }}"><i class="fas fa-sitemap"></i><span>Team Staff</span></a>
                </li>
                <li class="{{ request()->routeIs('leave.*') ? 'active' : '' }}">
                    <a href="{{ route('leave.index') }}"><i class="fas fa-umbrella-beach"></i><span>My Leave</span></a>
                </li>
                <li class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                    <a href="{{ route('calendar.index') }}"><i class="fas fa-calendar-alt"></i><span>Calendar</span></a>
                </li>
                <li class="{{ request()->routeIs('birthdays.*') ? 'active' : '' }}">
                    <a href="{{ route('birthdays.index') }}"><i class="fas fa-gift"></i><span>Staff Birthday</span></a>
                </li>
                <li class="sidebar-logout">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </aside>

    <main class="dashboard-main">
        <div class="topbar">
            <div class="topbar-breadcrumb">
                <i class="fas fa-home"></i><span style="opacity:.4;">›</span>
                <span class="current">Dashboard</span>
            </div>
            <div class="topbar-right">
                <div class="topbar-date">
                    <i class="fas fa-calendar" style="margin-right:6px;color:var(--teal-bright);"></i>
                    <span id="topbarDate"></span>
                </div>
                <div class="topbar-icon-btn"><i class="fas fa-cog"></i></div>
            </div>
        </div>

        <div class="page-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-home"></i> Dashboard Overview</h2>
                <p>Welcome back! Here's what's happening today.</p>
            </div>

            @if($datesNotSet)
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Action Required:</strong> Please update your internship period in
                    <a href="{{ route('profile.edit') }}">My Profile</a>
                    before applying for leave. You must set your start date and end date.
                </div>
            </div>
            @endif

            @if(session('success'))
                <div class="success-message"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <div class="top-stats-row">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
                    <div class="stat-info">
                        <h3>Days Working</h3>
                        <h2>{{ $daysWorked }}</h2>
                        @if(Auth::user()->internship_start_date)
                            <p>Started: {{ \Carbon\Carbon::parse(Auth::user()->internship_start_date)->format('d M Y') }}</p>
                        @else
                            <p>Not set</p>
                        @endif
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-info">
                        <h3>Days Remaining</h3>
                        <h2>{{ $daysRemaining }}</h2>
                        @if(Auth::user()->internship_end_date)
                            <p>Ends: {{ \Carbon\Carbon::parse(Auth::user()->internship_end_date)->format('d M Y') }}</p>
                        @else
                            <p>Not set</p>
                        @endif
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-info">
                        <h3>Position</h3>
                        <h2 style="font-size:15px;padding-top:4px;">{{ Auth::user()->position ?? 'Intern' }}</h2>
                    </div>
                </div>
            </div>

            <div class="main-content-grid">
                <div class="calendar-container">
                    <div class="mini-calendar-header">
                        <button class="mini-nav-btn" onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                        <h4 id="calendarTitle">{{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}</h4>
                        <button class="mini-nav-btn" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="mini-calendar-grid" style="padding:16px 20px 6px;">
                        <div class="mini-weekday">S</div><div class="mini-weekday">M</div><div class="mini-weekday">T</div>
                        <div class="mini-weekday">W</div><div class="mini-weekday">T</div><div class="mini-weekday">F</div><div class="mini-weekday">S</div>
                    </div>
                    <div id="calendarDays" class="mini-calendar-grid" style="padding:0 20px 16px;"></div>
                    <div class="calendar-footer-row">
                        <div class="cal-legend">
                            <div class="legend-item"><div class="legend-dot" style="background:var(--teal-bright);"></div> Today</div>
                            <div class="legend-item"><div class="legend-dot" style="background:var(--red);"></div> On Leave</div>
                            <div class="legend-item"><div class="legend-dot" style="background:var(--blue);"></div> Event</div>
                        </div>
                        <a href="{{ route('calendar.index') }}" class="view-calendar-link">View Full Calendar <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="right-sidebar-widgets">
                    <div class="quick-link-widget">
                        <h3 class="widget-title"><i class="fas fa-bolt"></i> Quick Links</h3>
                        <div class="quick-links-grid">
                            <a href="{{ route('leave.apply') }}" class="quick-link-btn"><i class="fas fa-paper-plane"></i><span>Apply Leave</span></a>
                            <a href="{{ route('leave.index') }}" class="quick-link-btn"><i class="fas fa-calendar-check"></i><span>My Leave</span></a>
                            <a href="{{ route('calendar.index') }}" class="quick-link-btn"><i class="fas fa-calendar-alt"></i><span>View Calendar</span></a>
                            <a href="{{ route('intern.team-staff') }}" class="quick-link-btn"><i class="fas fa-sitemap"></i><span>View Team</span></a>
                            <a href="{{ route('profile.show') }}" class="quick-link-btn"><i class="fas fa-user"></i><span>My Profile</span></a>
                            <a href="{{ route('profile.edit') }}" class="quick-link-btn"><i class="fas fa-user-edit"></i><span>Edit Profile</span></a>
                        </div>
                    </div>
                    <div class="calendar-info-widget">
                        <h3 class="widget-title"><i class="fas fa-info-circle"></i> Calendar Info</h3>
                        <div id="calendarInfo" class="calendar-info-content">
                            <div class="calendar-info-empty"><i class="fas fa-calendar-day"></i><p>Click on a date to view details</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.getElementById('topbarDate').textContent = new Date().toLocaleDateString('en-MY', { weekday:'short', day:'numeric', month:'short', year:'numeric' });

let currentYear  = {{ $currentYear }};
let currentMonth = {{ $currentMonth }};
let calendarData = @json($calendarData);

function renderCalendar() {
    const c = document.getElementById('calendarDays');
    if (!c) return;
    c.innerHTML = '';
    const firstDay = new Date(currentYear, currentMonth-1, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    const daysInPrev  = new Date(currentYear, currentMonth-1, 0).getDate();
    const t = new Date(), tY = t.getFullYear(), tM = t.getMonth()+1, tD = t.getDate();

    for (let i = firstDay-1; i >= 0; i--) {
        const d = document.createElement('div'); d.className = 'mini-day empty'; d.textContent = daysInPrev - i; c.appendChild(d);
    }
    for (let day = 1; day <= daysInMonth; day++) {
        const d = document.createElement('div');
        const key = `${currentYear}-${String(currentMonth).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
        const isToday  = day===tD && currentMonth===tM && currentYear===tY;
        const hasLeave = calendarData[key]?.count > 0;
        const hasEvent = calendarData[key]?.events?.length > 0;
        d.className = 'mini-day'+(isToday?' today':'')+(hasLeave?' has-leave':'');
        d.textContent = day;
        d.onclick = () => showDateInfo(key, day);
        if (hasEvent) {
            const dot = document.createElement('div');
            dot.className = 'event-dot event-dot-'+calendarData[key].events[0].color;
            d.appendChild(dot);
        }
        c.appendChild(d);
    }
    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('calendarTitle').textContent = `${months[currentMonth-1]} ${currentYear}`;
}

function showDateInfo(key, day) {
    const data = calendarData[key];
    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    const box = document.getElementById('calendarInfo');
    if (!data || (!data.leaves.length && !data.events.length)) {
        box.innerHTML = `<div class="selected-date-header">${day} ${months[currentMonth-1]} ${currentYear}</div><div class="calendar-info-empty"><i class="fas fa-calendar-check"></i><p>No leaves or events on this date</p></div>`;
        return;
    }
    let html = `<div class="selected-date-header">${day} ${months[currentMonth-1]} ${currentYear}</div>`;
    if (data.leaves.length) {
        html += `<div class="leave-info-list"><h5><i class="fas fa-umbrella-beach"></i> Staff on Leave (${data.count})</h5>`;
        data.leaves.forEach(l => { html += `<div class="leave-info-item"><strong>${l.staff_name}</strong><span><i class="fas fa-tag"></i> ${l.leave_type_name}</span><br><small>${l.total_days} day(s)</small></div>`; });
        html += '</div>';
    }
    if (data.events.length) {
        html += `<div class="event-info-list" style="margin-top:8px;"><h5><i class="fas fa-star"></i> Events</h5>`;
        data.events.forEach(ev => { html += `<div class="event-info-item event-${ev.color}"><strong>${ev.title}</strong><br>${ev.description?`<small>${ev.description}</small><br>`:''}<small><i class="fas fa-user"></i> ${ev.created_by}</small></div>`; });
        html += '</div>';
    }
    box.innerHTML = html;
}

function previousMonth() { currentMonth--; if(currentMonth<1){currentMonth=12;currentYear--;} window.location.href='{{ route('intern.dashboard') }}?year='+currentYear+'&month='+currentMonth; }
function nextMonth()     { currentMonth++; if(currentMonth>12){currentMonth=1;currentYear++;} window.location.href='{{ route('intern.dashboard') }}?year='+currentYear+'&month='+currentMonth; }

document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
    const msg = document.querySelector('.success-message');
    if (msg) { setTimeout(() => { msg.style.transition='opacity 1s ease'; msg.style.opacity='0'; setTimeout(()=>msg.remove(),1000); }, 5000); }
});
</script>
</body>
</html>
