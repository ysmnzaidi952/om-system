{{-- C:\laragon\www\om_system\resources\views\calendar\index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calendar | O&M HRCare</title>
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
            --red: #ef4444; --amber: #f59e0b; --green: #22c55e; --blue: #3b82f6;
            --accent: #0EA5A0; --white: #ffffff;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--off-white); color: var(--text-main); font-size: 14px; line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        .dashboard-layout { display: flex; min-height: 100vh; }

        /* ══ MAIN ══ */
        .dashboard-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }
        .page-content { padding: 24px 28px; flex: 1; }

        /* ══ ALERTS ══ */
        .alert { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; font-weight: 500; }
        .alert-success { background: rgba(34,197,94,0.1); color: #15803d; border: 1px solid rgba(34,197,94,0.25); }
        .alert-error   { background: rgba(239,68,68,0.1);  color: #dc2626; border: 1px solid rgba(239,68,68,0.25); }

        /* ══ CALENDAR WRAPPER ══ */
        .calendar-wrapper { background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); overflow: hidden; }

        /* ══ CALENDAR HEADER ══ */
        .cal-header { background: var(--teal-base); padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; }
        .cal-nav { display: flex; align-items: center; gap: 16px; }
        .cal-title { font-size: 16px; font-weight: 600; color: #fff; min-width: 200px; text-align: center; letter-spacing: 0.3px; }
        .nav-btn { background: rgba(255,255,255,0.12); color: #fff; border: none; width: 34px; height: 34px; border-radius: 7px; cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .nav-btn:hover { background: rgba(255,255,255,0.22); }
        .cal-actions { display: flex; gap: 8px; }
        .btn-today { background: rgba(255,255,255,0.12); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 7px 14px; border-radius: 7px; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.2s; font-family: var(--font); display: flex; align-items: center; gap: 6px; }
        .btn-today:hover { background: rgba(255,255,255,0.22); }
        .btn-add-event { background: var(--teal-bright); color: #fff; border: none; padding: 7px 14px; border-radius: 7px; font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.2s; font-family: var(--font); display: flex; align-items: center; gap: 6px; }
        .btn-add-event:hover { background: #0c9490; }

        /* ══ GRID ══ */
        .cal-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); background: var(--off-white); border-bottom: 1px solid var(--border); }
        .weekday { padding: 10px; text-align: center; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); }
        .cal-days { display: grid; grid-template-columns: repeat(7, 1fr); }
        .cal-day { min-height: 110px; padding: 8px; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); cursor: pointer; transition: background 0.15s; display: flex; flex-direction: column; gap: 3px; position: relative; overflow: hidden; }
        .cal-day:nth-child(7n) { border-right: none; }
        .cal-day:hover { background: var(--off-white); }
        .cal-day.other-month { background: #fafafa; opacity: 0.45; cursor: default; }
        .cal-day.today { background: rgba(14,165,160,0.06); }
        .cal-day.today .day-num { background: var(--teal-bright); color: #fff; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        .day-num { font-size: 12px; font-weight: 600; color: var(--text-main); width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .leave-count-badge { position: absolute; top: 6px; right: 6px; background: var(--teal-bright); color: #fff; width: 20px; height: 20px; border-radius: 50%; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; }

        /* ══ LEAVE & EVENT PILLS ══ */
        .pill { padding: 2px 7px; border-radius: 4px; font-size: 10px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 4px; border-left: 2px solid transparent; max-width: 100%; cursor: default; position: relative; }
        .pill i { font-size: 9px; flex-shrink: 0; }
        .pill[title]:hover::after { content: attr(title); position: absolute; bottom: calc(100% + 4px); left: 0; background: var(--teal-dark); color: #fff; padding: 4px 8px; border-radius: 5px; font-size: 10px; white-space: nowrap; z-index: 999; pointer-events: none; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .pill-more { color: var(--teal-bright); font-size: 10px; font-weight: 600; padding: 2px 4px; }

        /* Leave type colours */
        .leave-al,.leave-el,.leave-half_day_al,.leave-half_day_el { background: rgba(14,165,160,0.12); color: #0a5654; border-left-color: var(--teal-bright); }
        .leave-mc,.leave-mrl { background: rgba(239,68,68,0.1); color: #b91c1c; border-left-color: var(--red); }
        .leave-cl { background: rgba(245,158,11,0.1); color: #92400e; border-left-color: var(--amber); }
        .leave-wfh { background: rgba(34,197,94,0.1); color: #166534; border-left-color: var(--green); }
        .leave-ml { background: rgba(236,72,153,0.1); color: #9d174d; border-left-color: #ec4899; }
        .leave-pl { background: rgba(59,130,246,0.1); color: #1e40af; border-left-color: var(--blue); }
        .leave-rl { background: rgba(139,92,246,0.1); color: #5b21b6; border-left-color: #8b5cf6; }
        .leave-sl { background: rgba(249,115,22,0.1); color: #c2410c; border-left-color: #f97316; }

        /* Event colours */
        .event-green  { background: #fdf3e7; color: #6b3a1f; border-left-color: #c2622a; font-weight: 600; }
        .event-yellow { background: #fef9c3; color: #713f12; border-left-color: #eab308; font-weight: 600; }
        .event-orange { background: #ffedd5; color: #7c2d12; border-left-color: #f97316; font-weight: 600; }
        .event-red    { background: #fee2e2; color: #7f1d1d; border-left-color: #ef4444; font-weight: 600; }
        .event-blue   { background: #dbeafe; color: #1e3a8a; border-left-color: #2563eb; font-weight: 600; }
        .event-purple { background: #ede9fe; color: #4c1d95; border-left-color: #7c3aed; font-weight: 600; }
        .event-pink   { background: #fce7f3; color: #831843; border-left-color: #db2777; font-weight: 600; }

        /* ══ LEGEND ══ */
        .cal-legend { padding: 16px 20px; border-top: 1px solid var(--border); background: var(--off-white); display: flex; flex-wrap: wrap; gap: 10px 20px; align-items: center; }
        .cal-legend-title { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); width: 100%; margin-bottom: 2px; }
        .legend-item { display: flex; align-items: center; gap: 6px; font-size: 11px; color: var(--text-muted); }
        .legend-dot { width: 28px; height: 14px; border-radius: 3px; border-left: 2px solid transparent; flex-shrink: 0; }

        /* ══ DETAILS PANEL ══ */
        .details-panel { position: fixed; right: -420px; top: 0; width: 420px; height: 100vh; background: #fff; box-shadow: -4px 0 32px rgba(6,62,60,0.12); transition: right 0.3s ease; z-index: 1000; overflow-y: auto; display: flex; flex-direction: column; }
        .details-panel.active { right: 0; }
        .details-hdr { background: var(--teal-base); color: #fff; padding: 20px 22px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 10; }
        .details-hdr h3 { font-size: 15px; font-weight: 600; margin: 0; }
        .close-panel { background: rgba(255,255,255,0.15); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .close-panel:hover { background: rgba(255,255,255,0.28); transform: rotate(90deg); }
        .details-body { padding: 20px; flex: 1; }
        .detail-section { margin-bottom: 20px; }
        .detail-section-title { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .detail-section-title i { color: var(--teal-bright); }
        .detail-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }
        .detail-list li { padding: 10px 12px; background: var(--off-white); border-radius: 8px; border-left: 3px solid var(--teal-bright); font-size: 12px; }
        .detail-list li strong { font-size: 13px; color: var(--text-main); display: block; margin-bottom: 2px; }
        .detail-list li small { color: var(--text-muted); }
        .detail-empty { text-align: center; padding: 40px 20px; color: var(--text-muted); }
        .detail-empty i { font-size: 36px; opacity: 0.2; margin-bottom: 12px; display: block; color: var(--teal-bright); }
        .detail-empty p { font-size: 12px; }

        /* ══ MODAL ══ */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(4,46,44,0.5); z-index: 2000; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-content { background: #fff; width: 90%; max-width: 480px; border-radius: 12px; box-shadow: var(--shadow-md); animation: modalIn 0.25s ease; overflow: hidden; }
        @keyframes modalIn { from { opacity:0; transform: translateY(-20px); } to { opacity:1; transform: translateY(0); } }
        .modal-hdr { background: var(--teal-base); color: #fff; padding: 18px 22px; display: flex; align-items: center; gap: 10px; }
        .modal-hdr h3 { font-size: 15px; font-weight: 600; margin: 0; }
        .modal-body { padding: 22px; }
        .modal-footer { padding: 14px 22px; background: var(--off-white); border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px; }
        .form-control { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 7px; font-family: var(--font); font-size: 13px; color: var(--text-main); background: #fff; outline: none; transition: border 0.2s; }
        .form-control:focus { border-color: var(--teal-bright); box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .btn { padding: 8px 18px; border-radius: 7px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; font-family: var(--font); transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
        .btn-primary { background: var(--teal-bright); color: #fff; }
        .btn-primary:hover { background: #0c9490; }
        .btn-secondary { background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #e4f4f4; color: var(--text-main); }

        /* ══ OVERLAY backdrop ══ */
        .panel-overlay { display: none; position: fixed; inset: 0; background: rgba(4,46,44,0.3); z-index: 999; }
        .panel-overlay.active { display: block; }

        @media (max-width: 768px) {
            .cal-day { min-height: 70px; padding: 5px; }
            .details-panel { width: 100%; right: -100%; }
            .cal-header { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>
<div class="dashboard-layout">

    {{-- ══ SIDEBAR ══ --}}
    @include('components.sidebar2')

    <main class="dashboard-main">
        <div class="topbar">
            <div class="topbar-breadcrumb">
                <i class="fas fa-home"></i>
                <span style="opacity:.4;">›</span>
                <span class="current">Calendar</span>
            </div>
            @if(in_array(Auth::user()->role, ['admin','superadmin']))
            <button class="btn-add-event" onclick="showAddEventModal()">
                <i class="fas fa-plus"></i> Add Event
            </button>
            @endif
        </div>

        <div class="page-content">

            @if(session('success'))
            <div class="alert alert-success" id="alertSuccess">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-error" id="alertError">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
            @endif

            <div class="calendar-wrapper">
                <div class="cal-header">
                    <div class="cal-nav">
                        <button class="nav-btn" onclick="previousMonth()"><i class="fas fa-chevron-left"></i></button>
                        <div class="cal-title" id="calendarTitle">{{ date('F Y', mktime(0,0,0,$month,1,$year)) }}</div>
                        <button class="nav-btn" onclick="nextMonth()"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <button class="btn-today" onclick="goToToday()">
                        <i class="fas fa-calendar-day"></i> Today
                    </button>
                </div>

                <div class="cal-weekdays">
                    <div class="weekday">Sun</div>
                    <div class="weekday">Mon</div>
                    <div class="weekday">Tue</div>
                    <div class="weekday">Wed</div>
                    <div class="weekday">Thu</div>
                    <div class="weekday">Fri</div>
                    <div class="weekday">Sat</div>
                </div>

                <div class="cal-days" id="calendarDays"></div>

                <div class="cal-legend">
                    <div class="cal-legend-title">Legend</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(14,165,160,0.12);border-left-color:var(--teal-bright);"></div>AL / EL</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(239,68,68,0.1);border-left-color:var(--red);"></div>MC / MRL</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(245,158,11,0.1);border-left-color:var(--amber);"></div>CL</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(34,197,94,0.1);border-left-color:var(--green);"></div>WFH</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(236,72,153,0.1);border-left-color:#ec4899;"></div>ML</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(59,130,246,0.1);border-left-color:var(--blue);"></div>PL</div>
                    <div class="legend-item"><div class="legend-dot" style="background:rgba(139,92,246,0.1);border-left-color:#8b5cf6;"></div>RL</div>
                    <div class="legend-item"><div class="legend-dot" style="background:#fdf3e7;border-left-color:#c2622a;"></div>Events</div>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="panel-overlay" id="panelOverlay" onclick="closeDetailsPanel()"></div>

<div class="details-panel" id="detailsPanel">
    <div class="details-hdr">
        <h3 id="detailsDate"></h3>
        <button class="close-panel" onclick="closeDetailsPanel()"><i class="fas fa-times"></i></button>
    </div>
    <div class="details-body" id="detailsContent"></div>
</div>

@if(in_array(Auth::user()->role, ['admin','superadmin']))
<div class="modal-overlay" id="addEventModal">
    <div class="modal-content">
        <div class="modal-hdr">
            <i class="fas fa-calendar-plus"></i>
            <h3>Add Event</h3>
        </div>
        <form action="{{ route('calendar.event.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Event Title *</label>
                    <input type="text" class="form-control" name="title" required placeholder="e.g., Team meeting, Last day intern...">
                </div>
                <div class="form-group">
                    <label>Date *</label>
                    <input type="date" class="form-control" name="event_date" required>
                </div>
                <div class="form-group">
                    <label>Description (Optional)</label>
                    <textarea class="form-control" name="description" rows="3" placeholder="Additional details..."></textarea>
                </div>
                <div class="form-group">
                    <label>Colour *</label>
                    <select class="form-control" name="color" required>
                        <option value="green">Cyan</option>
                        <option value="yellow">Yellow</option>
                        <option value="orange">Orange</option>
                        <option value="red">Red</option>
                        <option value="blue">Blue</option>
                        <option value="purple">Purple</option>
                        <option value="pink">Pink</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddEventModal()"><i class="fas fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Event</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    let currentYear  = {{ $year }};
    let currentMonth = {{ $month }};
    let calendarData = @json($calendarData);

    function renderCalendar() {
        const container = document.getElementById('calendarDays');
        container.innerHTML = '';

        const firstDay    = new Date(currentYear, currentMonth - 1, 1).getDay();
        const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
        const daysInPrev  = new Date(currentYear, currentMonth - 1, 0).getDate();

        const today  = new Date();
        const todayY = today.getFullYear();
        const todayM = today.getMonth() + 1;
        const todayD = today.getDate();

        for (let i = firstDay - 1; i >= 0; i--) {
            container.appendChild(makeDayEl(daysInPrev - i, true, false, null));
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const isToday = d === todayD && currentMonth === todayM && currentYear === todayY;
            const dateKey = currentYear + '-' + String(currentMonth).padStart(2,'0') + '-' + String(d).padStart(2,'0');
            container.appendChild(makeDayEl(d, false, isToday, dateKey));
        }

        const filled    = container.children.length;
        const remaining = (Math.ceil(filled / 7) * 7) - filled;
        for (let d = 1; d <= remaining; d++) {
            container.appendChild(makeDayEl(d, true, false, null));
        }

        const monthNames = ['January','February','March','April','May','June',
                            'July','August','September','October','November','December'];
        document.getElementById('calendarTitle').textContent = monthNames[currentMonth-1] + ' ' + currentYear;
    }

    function makeDayEl(day, otherMonth, isToday, dateKey) {
        const el = document.createElement('div');
        el.className = 'cal-day' + (otherMonth ? ' other-month' : '') + (isToday ? ' today' : '');

        const numEl = document.createElement('div');
        numEl.className = 'day-num';
        numEl.textContent = day;
        el.appendChild(numEl);

        if (!otherMonth && dateKey) {
            const data = calendarData[dateKey];

            if (data) {
                if (data.count > 0) {
                    const badge = document.createElement('div');
                    badge.className = 'leave-count-badge';
                    badge.textContent = data.count;
                    el.appendChild(badge);
                }

                data.leaves.slice(0, 2).forEach(leave => {
                    const pill = document.createElement('div');
                    pill.className = 'pill leave-' + leave.leave_type.toLowerCase();
                    pill.innerHTML = '<i class="fas fa-user"></i>' + leave.staff_name;
                    pill.title = leave.staff_name;
                    el.appendChild(pill);
                });

                if (data.leaves.length > 2) {
                    const more = document.createElement('div');
                    more.className = 'pill-more';
                    more.textContent = '+' + (data.leaves.length - 2) + ' more';
                    el.appendChild(more);
                }

                data.events.forEach(evt => {
                    const pill = document.createElement('div');
                    pill.className = 'pill event-' + evt.color;
                    pill.innerHTML = '<i class="fas fa-circle" style="font-size:6px;"></i>' + evt.title;
                    pill.title = evt.title;
                    el.appendChild(pill);
                });
            }

            el.onclick = () => showDayDetails(dateKey, day);
        }

        return el;
    }

    function showDayDetails(dateKey, day) {
        const data = calendarData[dateKey];
        const monthNames = ['January','February','March','April','May','June',
                            'July','August','September','October','November','December'];
        document.getElementById('detailsDate').textContent = day + ' ' + monthNames[currentMonth-1] + ' ' + currentYear;

        let html = '';

        if (!data || (data.leaves.length === 0 && data.events.length === 0)) {
            html = '<div class="detail-empty"><i class="fas fa-calendar-day"></i><p>No leaves or events on this day.</p></div>';
        } else {
            if (data.leaves.length > 0) {
                html += '<div class="detail-section"><div class="detail-section-title"><i class="fas fa-umbrella-beach"></i> Staff on Leave (' + data.count + ')</div><ul class="detail-list">';
                data.leaves.forEach(l => {
                    html += '<li><strong>' + l.staff_name + '</strong>';
                    html += '<small>' + l.leave_type_name + '</small>';
                    if (l.start_date && l.end_date) {
                        html += '<br><small style="color:var(--text-muted);">' +
                            (l.start_date === l.end_date ? '1 day' : l.start_date + ' → ' + l.end_date + ' (' + l.total_days + ' days)') +
                            '</small>';
                    }
                    html += '</li>';
                });
                html += '</ul></div>';
            }

            if (data.events.length > 0) {
                html += '<div class="detail-section"><div class="detail-section-title"><i class="fas fa-star"></i> Events</div><ul class="detail-list">';
                data.events.forEach(ev => {
                    const borderColor = getEventHex(ev.color);
                    html += '<li style="border-left-color:' + borderColor + '"><strong>' + ev.title + '</strong>';
                    if (ev.description) html += '<br><small>' + ev.description + '</small>';
                    html += '<br><small style="color:var(--text-muted);"><i class="fas fa-user"></i> ' + ev.created_by + '</small></li>';
                });
                html += '</ul></div>';
            }
        }

        document.getElementById('detailsContent').innerHTML = html;
        document.getElementById('detailsPanel').classList.add('active');
        document.getElementById('panelOverlay').classList.add('active');
    }

    function getEventHex(color) {
        const map = { green:'#c2622a', yellow:'#eab308', orange:'#f97316', red:'#ef4444', blue:'#2563eb', purple:'#7c3aed', pink:'#db2777' };
        return map[color] || '#22c55e';
    }

    function closeDetailsPanel() {
        document.getElementById('detailsPanel').classList.remove('active');
        document.getElementById('panelOverlay').classList.remove('active');
    }

    function previousMonth() {
        currentMonth--;
        if (currentMonth < 1) { currentMonth = 12; currentYear--; }
        reloadCalendar();
    }

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 12) { currentMonth = 1; currentYear++; }
        reloadCalendar();
    }

    function goToToday() {
        const t = new Date();
        currentYear  = t.getFullYear();
        currentMonth = t.getMonth() + 1;
        reloadCalendar();
    }

    function reloadCalendar() {
        window.location.href = '{{ route('calendar.index') }}?year=' + currentYear + '&month=' + currentMonth;
    }

    @if(in_array(Auth::user()->role, ['admin','superadmin']))
    function showAddEventModal() {
        document.getElementById('addEventModal').classList.add('active');
    }
    function closeAddEventModal() {
        document.getElementById('addEventModal').classList.remove('active');
    }
    document.getElementById('addEventModal').addEventListener('click', function(e) {
        if (e.target === this) closeAddEventModal();
    });
    @endif

    document.addEventListener('DOMContentLoaded', function() {
        ['alertSuccess','alertError'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 5000);
        });
        renderCalendar();
    });
</script>
</body>
</html>
