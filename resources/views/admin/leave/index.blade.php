{{-- C:\laragon\www\om_system\resources\views\admin\leave\index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management | O&M HRCare</title>
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
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
        }

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
            padding: 0 28px;
            gap: 8px;
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

        .topbar-breadcrumb span { color: var(--text-muted); }
        .topbar-breadcrumb .sep { opacity: .5; }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 600; }

        /* ── PAGE CONTENT ── */
        .page-content {
            padding: 24px 28px;
            flex: 1;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
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

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 20px;
        }

        .stat-icon.purple { background: rgba(124,58,237,0.1); color: var(--purple); }
        .stat-icon.blue   { background: rgba(59,130,246,0.1);  color: var(--blue); }
        .stat-icon.green  { background: rgba(34,197,94,0.1);   color: var(--green); }
        .stat-icon.teal   { background: var(--teal-soft);       color: var(--teal-bright); }
        .stat-icon.amber  { background: rgba(245,158,11,0.1);  color: var(--amber); }

        .stat-info { flex: 1; min-width: 0; }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1;
        }

        /* ── QUICK ACTIONS ── */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .quick-action-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: var(--text-main);
            box-shadow: var(--shadow-sm);
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .quick-action-card:hover {
            background: var(--teal-bright);
            border-color: var(--teal-bright);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: #fff;
        }

        .quick-action-card:hover .qa-icon {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        .quick-action-card:hover .qa-label {
            color: #fff;
        }

        .qa-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--teal-soft);
            color: var(--teal-bright);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
            transition: all .2s;
        }

        .qa-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            transition: color .2s;
        }

        .qa-badge {
            position: absolute;
            top: 8px;
            right: 10px;
            background: var(--red);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* ── TABLE CONTAINER ── */
        .table-container {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .table-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-title i { color: var(--teal-bright); }

        /* ── SCROLL HINT ── */
        .scroll-hint {
            padding: 10px 20px;
            background: rgba(14,165,160,0.06);
            border-bottom: 1px solid var(--teal-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .scroll-hint-text {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .scroll-hint-text i { color: var(--teal-bright); }

        .scroll-hint-btns { display: flex; gap: 8px; }

        .scroll-btn {
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .scroll-btn:hover { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .scroll-btn.primary { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .scroll-btn.primary:hover { background: var(--teal-base); border-color: var(--teal-base); }

        /* ── TABLE WRAPPER ── */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        .table-wrapper::-webkit-scrollbar { height: 6px; }
        .table-wrapper::-webkit-scrollbar-track { background: var(--off-white); }
        .table-wrapper::-webkit-scrollbar-thumb { background: var(--teal-bright); border-radius: 6px; }

        /* ── DATA TABLE ── */
        .data-table {
            width: 100%;
            min-width: 1000px;
            border-collapse: collapse;
        }

        .data-table thead th {
            padding: 11px 16px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--text-muted);
            background: var(--off-white);
            border-bottom: 1px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }

        .data-table tbody td {
            padding: 12px 16px;
            font-size: 12px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .data-table tbody tr:last-child td { border-bottom: none; }

        .data-table tbody tr:hover { background: rgba(14,165,160,0.03); }

        /* ── STAFF CELL ── */
        .staff-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .staff-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal-base), var(--teal-bright));
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .staff-name { font-weight: 600; font-size: 12px; }
        .staff-pos  { font-size: 11px; color: var(--text-muted); }

        /* ── LEAVE TYPE BADGE ── */
        .leave-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .leave-al, .leave-el   { background: rgba(14,165,160,0.12); color: var(--teal-base); }
        .leave-mc               { background: rgba(239,68,68,0.1);   color: #b91c1c; }
        .leave-cl               { background: rgba(124,58,237,0.1);  color: var(--purple); }
        .leave-wfh              { background: rgba(59,130,246,0.1);  color: var(--blue); }
        .leave-ml, .leave-pl    { background: rgba(245,158,11,0.1);  color: #92400e; }
        .leave-mrl              { background: rgba(236,72,153,0.1);  color: #9d174d; }
        .leave-rl               { background: rgba(34,197,94,0.1);   color: #166534; }

        /* ── STATUS BADGE ── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .status-pending         { background: rgba(245,158,11,0.12); color: #92400e; }
        .status-approved        { background: rgba(34,197,94,0.12);  color: #166534; }
        .status-rejected        { background: rgba(239,68,68,0.12);  color: #991b1b; }
        .status-waiting-list    { background: rgba(59,130,246,0.12); color: #1e40af; }
        .status-cancelled       { background: rgba(107,114,128,0.12);color: #374151; }
        .status-special-case-approved { background: rgba(124,58,237,0.12); color: #5b21b6; }

        /* ── ICON BUTTON ── */
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

        .icon-btn:hover { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .icon-btn.refresh:hover { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 48px 24px;
            text-align: center;
        }

        .empty-state i {
            font-size: 40px;
            color: var(--text-muted);
            opacity: 0.3;
            display: block;
            margin-bottom: 12px;
        }

        .empty-state h3 { font-size: 15px; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 12px; color: var(--text-muted); }

        /* ── HALF DAY BADGE ── */
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

        /* ── DAYS NUMBER ── */
        .days-num {
            font-size: 13px;
            font-weight: 700;
            color: var(--teal-bright);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
            .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .quick-actions-grid { grid-template-columns: 1fr 1fr; }
            .page-content { padding: 16px; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
            .quick-actions-grid { grid-template-columns: 1fr; }
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
                <span class="current">Leave Management</span>
            </div>
        </div>

        <div class="page-content">

            {{-- Page Header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-calendar-check" style="color:var(--teal-bright);margin-right:8px;"></i>
                        Leave Management
                    </div>
                    <div class="page-subtitle">Manage staff leave applications and entitlements</div>
                </div>
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

            {{-- Stat Cards --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-clock"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Pending Approvals</div>
                        <div class="stat-value">{{ $pendingCount }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Waiting List</div>
                        <div class="stat-value">{{ $waitingListCount }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info">
                        <div class="stat-label">Approved This Month</div>
                        <div class="stat-value">{{ $approvedThisMonth }}</div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="quick-actions-grid" style="grid-template-columns: repeat(5, 1fr);">
                <a href="{{ route('admin.leave.pending') }}" class="quick-action-card">
                    @if($pendingCount > 0)
                    <span class="qa-badge">{{ $pendingCount }}</span>
                    @endif
                    <div class="qa-icon"><i class="fas fa-clock"></i></div>
                    <span class="qa-label">Pending Approvals</span>
                </a>

                <a href="{{ route('admin.leave.by-date') }}" class="quick-action-card">
                    <div class="qa-icon"><i class="fas fa-calendar-day"></i></div>
                    <span class="qa-label">Leave by Date</span>
                </a>

                <a href="{{ route('admin.leave.staff-entitlements') }}" class="quick-action-card">
                    <div class="qa-icon"><i class="fas fa-users"></i></div>
                    <span class="qa-label">Staff Balances</span>
                </a>

                <a href="{{ route('admin.leave.all-applications') }}" class="quick-action-card">
                    <div class="qa-icon"><i class="fas fa-list"></i></div>
                    <span class="qa-label">All Applications</span>
                </a>

                <a href="{{ route('admin.leave.apply-for-staff') }}" class="quick-action-card">
                    <div class="qa-icon"><i class="fas fa-user-plus"></i></div>
                    <span class="qa-label">Apply for Staff</span>
                </a>
            </div>

            {{-- Recent Applications Table --}}
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-history"></i> Recent Applications
                    </div>
                    <button class="icon-btn refresh" onclick="location.reload()" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                @if($recentApplications->count() > 0)

                <div class="scroll-hint">
                    <div class="scroll-hint-text">
                        <i class="fas fa-arrows-left-right"></i> Scroll right to see all columns
                    </div>
                    <div class="scroll-hint-btns">
                        <button class="scroll-btn" onclick="scrollTbl('appsWrapper','left')">
                            <i class="fas fa-chevron-left"></i> Left
                        </button>
                        <button class="scroll-btn primary" onclick="scrollTbl('appsWrapper','right')">
                            Right <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="table-wrapper" id="appsWrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff</th>
                                <th>Type</th>
                                <th>Leave Period</th>
                                <th>Days</th>
                                <th>Applied</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentApplications as $index => $application)
                            @php
                                if ($application->leave_type === 'HALF_DAY_AL') {
                                    $displayType = 'AL ½'; $leaveClass = 'leave-al';
                                } elseif ($application->leave_type === 'HALF_DAY_EL') {
                                    $displayType = 'EL ½'; $leaveClass = 'leave-el';
                                } else {
                                    $displayType = $application->leave_type;
                                    $leaveClass = 'leave-' . strtolower(str_replace('_', '-', $application->leave_type));
                                }

                                $statusMap = [
                                    'pending'              => ['class' => 'status-pending',       'icon' => 'fa-clock',          'label' => 'Pending'],
                                    'approved'             => ['class' => 'status-approved',      'icon' => 'fa-check-circle',   'label' => 'Approved'],
                                    'rejected'             => ['class' => 'status-rejected',      'icon' => 'fa-times-circle',   'label' => 'Rejected'],
                                    'waiting_list'         => ['class' => 'status-waiting-list',  'icon' => 'fa-hourglass-half', 'label' => 'Waiting List'],
                                    'cancelled'            => ['class' => 'status-cancelled',     'icon' => 'fa-ban',            'label' => 'Cancelled'],
                                    'special_case_approved'=> ['class' => 'status-special-case-approved', 'icon' => 'fa-star', 'label' => 'Special Case'],
                                ];
                                $st = $statusMap[$application->status] ?? ['class' => 'status-pending', 'icon' => 'fa-circle', 'label' => ucfirst($application->status)];
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="staff-cell">
                                        <div class="staff-avatar">{{ substr($application->user->name, 0, 1) }}</div>
                                        <div>
                                            <div class="staff-name">{{ $application->user->name }}</div>
                                            <div class="staff-pos">{{ $application->user->position ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <div style="font-weight:600;font-size:12px;">{{ $application->start_date->format('d/m/Y') }}</div>
                                    <div style="font-size:11px;color:var(--text-muted);">to {{ $application->end_date->format('d/m/Y') }}</div>
                                </td>
                                <td><span class="days-num">{{ $application->total_days }}</span></td>
                                <td style="font-size:11px;color:var(--text-muted);">{{ $application->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-badge {{ $st['class'] }}">
                                        <i class="fas {{ $st['icon'] }}"></i>
                                        {{ $st['label'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Applications</h3>
                    <p>There are no leave applications yet.</p>
                </div>
                @endif
            </div>

        </div>{{-- end page-content --}}
    </main>
</div>

<script>
function scrollTbl(id, dir) {
    const el = document.getElementById(id);
    el.scrollBy({ left: dir === 'left' ? -400 : 400, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function () {
    // Auto-dismiss alerts
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

    // Table scroll shadow indicator
    const wrapper = document.getElementById('appsWrapper');
    if (wrapper) {
        const updateShadow = () => {
            const atStart = wrapper.scrollLeft === 0;
            const atEnd   = wrapper.scrollLeft >= wrapper.scrollWidth - wrapper.clientWidth - 1;
            wrapper.style.boxShadow = atStart && atEnd ? 'none'
                : atStart ? 'inset -8px 0 12px -8px rgba(4,46,44,0.12)'
                : atEnd   ? 'inset 8px 0 12px -8px rgba(4,46,44,0.12)'
                : 'inset 8px 0 12px -8px rgba(4,46,44,0.12), inset -8px 0 12px -8px rgba(4,46,44,0.12)';
        };
        wrapper.addEventListener('scroll', updateShadow);
        updateShadow();
    }
});
</script>
</body>
</html>
