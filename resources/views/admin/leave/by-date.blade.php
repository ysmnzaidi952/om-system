{{-- C:\laragon\www\om_system\resources\views\admin\leave\by-date.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave by Date | O&M HRCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        /* ── DESIGN TOKENS ── */
        :root {
            --teal-dark:   #042e2c;
            --teal-base:   #0a5654;
            --teal-bright: #0EA5A0;
            --teal-soft:   rgba(14,165,160,0.10);
            --teal-border: rgba(14,165,160,0.15);
            --off-white:   #f0fafa;
            --text-main:   #0a2e2c;
            --text-muted:  #4a7a76;
            --border:      rgba(14,165,160,0.15);
            --shadow-sm:   0 1px 4px rgba(4,46,44,0.07);
            --shadow-md:   0 4px 16px rgba(4,46,44,0.10);
            --shadow-lg:   0 8px 28px rgba(4,46,44,0.14);
            --red:    #ef4444;
            --amber:  #f59e0b;
            --green:  #22c55e;
            --blue:   #3b82f6;
            --purple: #7c3aed;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--off-white);
            color: var(--text-main);
            font-size: 13px;
        }

        /* ── LAYOUT ── */
        .dashboard-layout { display: flex; min-height: 100vh; }

        .dashboard-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-breadcrumb {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-breadcrumb .sep { opacity: .5; }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 600; }

        /* ── PAGE CONTENT ── */
        .page-content { padding: 24px 28px; flex: 1; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-main);
            letter-spacing: -0.3px;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── ALERTS ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .alert-success {
            background: rgba(34,197,94,0.08);
            border: 1px solid rgba(34,197,94,0.25);
            color: #166534;
            border-left: 3px solid var(--green);
        }

        .alert-error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.25);
            color: #991b1b;
            border-left: 3px solid var(--red);
        }

        /* ── BACK BUTTON ── */
        .btn {
            padding: 8px 16px;
            border-radius: 7px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid var(--border);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            text-decoration: none;
            background: #fff;
            color: var(--text-muted);
        }

        .btn:hover {
            background: var(--teal-soft);
            color: var(--teal-base);
            border-color: var(--teal-bright);
        }

        .btn-primary {
            background: var(--teal-bright);
            color: #fff;
            border-color: var(--teal-bright);
        }

        .btn-primary:hover { background: var(--teal-base); border-color: var(--teal-base); color: #fff; }

        /* ── FILTER CARD ── */
        .filter-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .filter-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-card-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
        }

        .filter-card-title i { color: var(--teal-bright); }

        .filter-card-body { padding: 16px 20px; }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .form-group { display: flex; flex-direction: column; gap: 5px; }

        .form-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .form-label i { color: var(--teal-bright); }

        .form-select {
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 7px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: var(--text-main);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }

        .form-select:focus {
            border-color: var(--teal-bright);
            box-shadow: 0 0 0 3px rgba(14,165,160,0.1);
        }

        /* ── DATE CARDS ── */
        .date-cards-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .date-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: box-shadow .2s;
        }

        .date-card.expanded {
            box-shadow: var(--shadow-md);
        }

        /* ── DATE HEADER ── */
        .date-header {
            padding: 16px 20px;
            background: var(--teal-base);
            color: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            transition: background .2s;
        }

        .date-header:hover { background: var(--teal-dark); }

        .date-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Calendar icon block */
        .date-icon-block {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .date-icon-block .day {
            font-size: 20px;
            font-weight: 700;
            line-height: 1;
        }

        .date-icon-block .month {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.85;
        }

        .date-info h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .date-info p {
            font-size: 11px;
            opacity: 0.8;
        }

        /* ── DATE STATS (right side of header) ── */
        .date-stats {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            white-space: nowrap;
        }

        .limit-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .limit-pill.success { background: var(--green); color: #fff; }
        .limit-pill.warning { background: var(--amber); color: #fff; }
        .limit-pill.danger  { background: var(--red);   color: #fff; }

        .action-required-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            background: var(--amber);
            color: #fff;
            animation: pulse 2s infinite;
            white-space: nowrap;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.75; }
        }

        .expand-icon {
            font-size: 14px;
            transition: transform .3s;
            opacity: 0.8;
            flex-shrink: 0;
        }

        .date-card.expanded .expand-icon { transform: rotate(180deg); }

        /* ── APPLICATIONS LIST ── */
        .applications-list {
            display: none;
            padding: 16px;
            background: var(--off-white);
            border-top: 1px solid var(--border);
        }

        .date-card.expanded .applications-list { display: block; }

        /* ── APPLICATION ITEM ── */
        .application-item {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 14px 16px;
            margin-bottom: 10px;
            display: grid;
            grid-template-columns: 36px 1fr auto auto auto auto;
            gap: 16px;
            align-items: center;
            transition: box-shadow .2s, border-color .2s;
        }

        .application-item:last-child { margin-bottom: 0; }

        .application-item:hover {
            box-shadow: var(--shadow-sm);
            border-color: var(--teal-bright);
        }

        /* Position number badge */
        .position-badge {
            width: 32px;
            height: 32px;
            background: var(--teal-bright);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* Staff info */
        .staff-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .staff-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--teal-base);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .staff-name { font-size: 13px; font-weight: 600; }
        .staff-pos  { font-size: 11px; color: var(--text-muted); }

        /* Leave info */
        .leave-info { display: flex; flex-direction: column; gap: 3px; }

        .leave-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            width: fit-content;
        }

        .leave-al, .leave-el   { background: rgba(14,165,160,0.12); color: var(--teal-base); }
        .leave-mc               { background: rgba(239,68,68,0.1);   color: #b91c1c; }
        .leave-cl               { background: rgba(124,58,237,0.1);  color: var(--purple); }
        .leave-wfh              { background: rgba(59,130,246,0.1);  color: var(--blue); }
        .leave-ml, .leave-pl    { background: rgba(245,158,11,0.1);  color: #92400e; }
        .leave-mrl              { background: rgba(236,72,153,0.1);  color: #9d174d; }
        .leave-rl               { background: rgba(34,197,94,0.1);   color: #166534; }

        .leave-period {
            font-size: 11px;
            color: var(--text-muted);
        }

        .half-day-tag {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 4px;
            background: rgba(14,165,160,0.1);
            color: var(--teal-base);
            margin-left: 4px;
        }

        /* Applied date */
        .applied-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1px;
            text-align: center;
        }

        .applied-col .lbl  { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .applied-col .val  { font-size: 12px; font-weight: 600; }
        .applied-col .time { font-size: 10px; color: var(--text-muted); }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pending         { background: rgba(245,158,11,0.12); color: #92400e; }
        .status-approved        { background: rgba(34,197,94,0.12);  color: #166534; }
        .status-rejected        { background: rgba(239,68,68,0.12);  color: #991b1b; }
        .status-waiting-list    { background: rgba(59,130,246,0.12); color: #1e40af; }
        .status-cancelled       { background: rgba(107,114,128,0.12);color: #374151; }
        .status-special-case-approved { background: rgba(124,58,237,0.12); color: #5b21b6; }

        /* Action buttons */
        .action-cell { display: flex; align-items: center; gap: 6px; }

        .icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text-muted);
            font-size: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            text-decoration: none;
        }

        .icon-btn:hover         { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .icon-btn.approve:hover { background: var(--green); color: #fff; border-color: var(--green); }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 56px 24px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .empty-state i {
            font-size: 40px;
            color: var(--text-muted);
            opacity: 0.25;
            display: block;
            margin-bottom: 14px;
        }

        .empty-state h3 { font-size: 15px; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 12px; color: var(--text-muted); }

        /* ── RESPONSIVE ── */
        @media (max-width: 1200px) {
            .filter-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .application-item {
                grid-template-columns: 36px 1fr auto;
                gap: 12px;
            }

            .applied-col, .leave-info { display: none; }
        }

        @media (max-width: 768px) {
            .page-content { padding: 16px; }
            .filter-grid  { grid-template-columns: 1fr; }
            .page-header  { flex-direction: column; }
            .date-stats   { flex-wrap: wrap; gap: 6px; }
        }

        .icon-btn.dimmed {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }

        .icon-btn.cancel-btn:hover {
            background: var(--amber);
            color: #fff;
            border-color: var(--amber);
        }
    </style>
</head>

<body>
<div class="dashboard-layout">

    {{-- Sidebar --}}
    @include('components.sidebar2')

    <main class="dashboard-main">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-breadcrumb">
                <span>Admin</span>
                <span class="sep">›</span>
                <span>Leave Management</span>
                <span class="sep">›</span>
                <span class="current">Leave by Date</span>
            </div>
        </div>

        <div class="page-content">

            {{-- Page Header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-calendar-day" style="color:var(--teal-bright);margin-right:8px;"></i>
                        Leave by Date
                    </div>
                    <div class="page-subtitle">View leave applications grouped by date — sorted by who applied first</div>
                </div>
                <a href="{{ route('admin.leave.index') }}" class="btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            {{-- Alerts --}}
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

            {{-- Filter Card --}}
            <div class="filter-card">
                <div class="filter-card-header">
                    <div class="filter-card-title">
                        <i class="fas fa-filter"></i> Filter by Month & Year
                    </div>
                </div>
                <div class="filter-card-body">
                    <form method="GET" action="{{ route('admin.leave.by-date') }}">
                        <div class="filter-grid">

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar"></i> Month</label>
                                <select class="form-select" id="month" name="month" onchange="this.form.submit()">
                                    @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar-alt"></i> Year</label>
                                <select class="form-select" id="year" name="year" onchange="this.form.submit()">
                                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-info-circle"></i> Status</label>
                                <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="pending"               {{ $status == 'pending'               ? 'selected' : '' }}>Pending</option>
                                    <option value="waiting_list"          {{ $status == 'waiting_list'          ? 'selected' : '' }}>Waiting List</option>
                                    <option value="approved"              {{ $status == 'approved'              ? 'selected' : '' }}>Approved</option>
                                    <option value="special_case_approved" {{ $status == 'special_case_approved' ? 'selected' : '' }}>Special Case</option>
                                    <option value="rejected"              {{ $status == 'rejected'              ? 'selected' : '' }}>Rejected</option>
                                    <option value="cancelled"             {{ $status == 'cancelled'             ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- Date Cards --}}
            @if(count($uniqueDates) > 0)
            <div class="date-cards-container">
                @foreach($uniqueDates as $date => $applications)
                @php
                    $dateCarbon = \Carbon\Carbon::parse($date);
                    $stats = $dateStats[$date];
                @endphp

                <div class="date-card" id="date-card-{{ $date }}">

                    {{-- Date Header --}}
                    <div class="date-header" onclick="toggleDateCard('{{ $date }}')">
                        <div class="date-header-left">
                            <div class="date-icon-block">
                                <div class="day">{{ $dateCarbon->format('d') }}</div>
                                <div class="month">{{ $dateCarbon->format('M') }}</div>
                            </div>
                            <div class="date-info">
                                <h3>{{ $dateCarbon->format('l, d F Y') }}</h3>
                                <p>{{ count($applications) }} application(s) for this date</p>
                            </div>
                        </div>

                        <div class="date-stats">
                            @if($stats['approved'] > 0)
                            <span class="stat-pill">
                                <i class="fas fa-check-circle"></i> {{ $stats['approved'] }} Approved
                            </span>
                            @endif

                            @if($stats['special_case'] > 0)
                            <span class="stat-pill">
                                <i class="fas fa-star"></i> {{ $stats['special_case'] }} Special
                            </span>
                            @endif

                            @if($stats['pending'] > 0)
                            <span class="stat-pill">
                                <i class="fas fa-clock"></i> {{ $stats['pending'] }} Pending
                            </span>
                            @endif

                            @if($stats['waiting_list'] > 0)
                            <span class="stat-pill">
                                <i class="fas fa-hourglass-half"></i> {{ $stats['waiting_list'] }} Waiting
                            </span>
                            @endif

                            @if($stats['pending'] > 0 || $stats['waiting_list'] > 0)
                            <span class="action-required-pill">
                                <i class="fas fa-exclamation-circle"></i> Action Required
                            </span>
                            @endif

                            <span class="limit-pill {{ $stats['status_color'] }}">
                                {{ $stats['total_approved'] }}/2 Limit
                            </span>

                            <i class="fas fa-chevron-down expand-icon"></i>
                        </div>
                    </div>

                    {{-- Applications List --}}
                    <div class="applications-list">
                        @foreach($applications as $index => $application)
                        @php
                            if ($application->leave_type === 'HALF_DAY_AL') {
                                $displayType = 'AL ½'; $leaveClass = 'leave-al';
                            } elseif ($application->leave_type === 'HALF_DAY_EL') {
                                $displayType = 'EL ½'; $leaveClass = 'leave-el';
                            } else {
                                $displayType = $application->leave_type;
                                $leaveClass  = 'leave-' . strtolower(str_replace('_', '-', $application->leave_type));
                            }

                            $statusMap = [
                                'pending'               => ['class' => 'status-pending',       'icon' => 'fa-clock',          'label' => 'Pending'],
                                'approved'              => ['class' => 'status-approved',      'icon' => 'fa-check-circle',   'label' => 'Approved'],
                                'rejected'              => ['class' => 'status-rejected',      'icon' => 'fa-times-circle',   'label' => 'Rejected'],
                                'waiting_list'          => ['class' => 'status-waiting-list',  'icon' => 'fa-hourglass-half', 'label' => 'Waiting List'],
                                'cancelled'             => ['class' => 'status-cancelled',     'icon' => 'fa-ban',            'label' => 'Cancelled'],
                                'special_case_approved' => ['class' => 'status-special-case-approved', 'icon' => 'fa-star',  'label' => 'Special Case'],
                            ];
                            $st = $statusMap[$application->status] ?? ['class' => 'status-pending', 'icon' => 'fa-circle', 'label' => ucfirst($application->status)];
                        @endphp

                        <div class="application-item">

                            {{-- Position number --}}
                            <div class="position-badge">{{ $index + 1 }}</div>

                            {{-- Staff info --}}
                            <div class="staff-cell">
                                <div class="staff-avatar">{{ substr($application->user->name, 0, 1) }}</div>
                                <div>
                                    <div class="staff-name">{{ $application->user->name }}</div>
                                    <div class="staff-pos">{{ $application->user->position ?? 'N/A' }}</div>
                                </div>
                            </div>

                            {{-- Leave type & period --}}
                            <div class="leave-info">
                                <span class="leave-badge {{ $leaveClass }}">
                                    @if(in_array($application->leave_type, ['AL','EL','HALF_DAY_AL','HALF_DAY_EL']))
                                        <i class="fas fa-umbrella-beach"></i>
                                    @elseif(in_array($application->leave_type, ['MC','ML','PL']))
                                        <i class="fas fa-notes-medical"></i>
                                    @elseif($application->leave_type === 'MRL')
                                        <i class="fas fa-heart"></i>
                                    @elseif($application->leave_type === 'CL')
                                        <i class="fas fa-hands-praying"></i>
                                    @elseif($application->leave_type === 'WFH')
                                        <i class="fas fa-home"></i>
                                    @else
                                        <i class="fas fa-calendar"></i>
                                    @endif
                                    {{ $displayType }}
                                </span>
                                @if($application->is_half_day)
                                    <span class="half-day-tag">{{ $application->half_day_period }}</span>
                                @endif
                                <div class="leave-period">
                                    {{ $application->start_date->format('d/m/Y') }} — {{ $application->end_date->format('d/m/Y') }}
                                    ({{ $application->total_days }} day{{ $application->total_days > 1 ? 's' : '' }})
                                </div>
                            </div>

                            {{-- Applied date --}}
                            <div class="applied-col">
                                <span class="lbl">Applied</span>
                                <span class="val">{{ $application->created_at->format('d/m/Y') }}</span>
                                <span class="time">{{ $application->created_at->format('h:i A') }}</span>
                            </div>

                            {{-- Status --}}
                            <div>
                                <span class="status-badge {{ $st['class'] }}">
                                    <i class="fas {{ $st['icon'] }}"></i> {{ $st['label'] }}
                                </span>
                            </div>

                            {{-- Actions --}}
                            {{-- Actions --}}
                            @php
                                $isPast = \Carbon\Carbon::parse($application->start_date)->lte(\Carbon\Carbon::today('Asia/Kuala_Lumpur'));
                            @endphp
                            <div class="action-cell">
                                {{-- View --}}
                                <a href="{{ route('admin.leave.show', $application->id) }}" class="icon-btn" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($application->status === 'pending' || $application->status === 'waiting_list')

                                {{-- Approve --}}
                                <form action="{{ route('admin.leave.approve', $application->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="icon-btn approve" title="Approve"
                                        onclick="return confirm('Approve leave for {{ $application->user->name }}?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                {{-- Cancel --}}
                                <form action="{{ route('leave.cancel', $application->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        class="icon-btn {{ $isPast ? 'dimmed' : 'cancel-btn' }}"
                                        title="{{ $isPast ? 'Cannot cancel — leave already started/passed' : 'Cancel Application' }}"
                                        {{ $isPast ? 'disabled' : '' }}
                                        {{ !$isPast ? 'onclick="return confirm(\'Cancel application for ' . addslashes($application->user->name) . '?\')"' : '' }}>
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <button type="button" class="icon-btn reject" title="Reject"
                                    onclick="showRejectModal({{ $application->id }}, '{{ addslashes($application->user->name) }}')">
                                    <i class="fas fa-times"></i>
                                </button>

                                @endif
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
                @endforeach
            </div>

            @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>No Applications Found</h3>
                <p>No leave applications for {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}.</p>
                <p style="margin-top:4px;">Try selecting a different month or year.</p>
            </div>
            @endif

        </div>{{-- end page-content --}}
    </main>
</div>

<script>
function toggleDateCard(date) {
    document.getElementById('date-card-' + date).classList.toggle('expanded');
}

document.addEventListener('DOMContentLoaded', function () {
    ['alertSuccess', 'alertError'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            setTimeout(() => {
                el.style.transition = 'opacity 1s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 1000);
            }, 5000);
        }
    });
});

function showRejectModal(applicationId, staffName) {
    if (confirm('Reject leave application for ' + staffName + '?\n\nThis action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/leave/reject/' + applicationId;
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
</body>
</html>
