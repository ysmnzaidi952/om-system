{{-- C:\laragon\www\om_system\resources\views\admin\leave\pending.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals | O&M HRCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
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

        /* Search box in topbar */
        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--off-white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 12px;
        }

        .search-box input {
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: var(--text-main);
            outline: none;
            width: 200px;
        }

        .search-box input::placeholder { color: var(--text-muted); }
        .search-box i { color: var(--text-muted); font-size: 12px; }

        /* ── PAGE CONTENT ── */
        .page-content { padding: 24px 28px; flex: 1; }

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

        .page-subtitle { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

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

        /* ── STAT CARD ── */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
            max-width: 300px;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            background: rgba(245,158,11,0.1);
            color: var(--amber);
        }

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
        }

        .table-title {
            font-size: 12px;
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
            display: flex;
            align-items: center;
            gap: 5px;
            font-family: 'Poppins', sans-serif;
            transition: all .2s;
        }

        .scroll-btn:hover         { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .scroll-btn.primary       { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
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
            min-width: 1300px;
            border-collapse: collapse;
        }

        .data-table thead th {
            padding: 11px 14px;
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
            padding: 12px 14px;
            font-size: 12px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background: rgba(14,165,160,0.03); }

        /* ── STAFF CELL ── */
        .staff-cell { display: flex; align-items: center; gap: 10px; }

        .staff-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--teal-base);
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
        }

        .leave-al, .leave-el           { background: rgba(14,165,160,0.12); color: var(--teal-base); }
        .leave-half-day-al,
        .leave-half-day-el             { background: rgba(14,165,160,0.12); color: var(--teal-base); }
        .leave-mc                      { background: rgba(239,68,68,0.1);   color: #b91c1c; }
        .leave-cl                      { background: rgba(124,58,237,0.1);  color: var(--purple); }
        .leave-wfh                     { background: rgba(59,130,246,0.1);  color: var(--blue); }
        .leave-ml, .leave-pl           { background: rgba(245,158,11,0.1);  color: #92400e; }
        .leave-mrl                     { background: rgba(236,72,153,0.1);  color: #9d174d; }
        .leave-rl                      { background: rgba(34,197,94,0.1);   color: #166534; }
        .leave-sl                      { background: rgba(245,158,11,0.12); color: #92400e; }

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

        .status-pending      { background: rgba(245,158,11,0.12); color: #92400e; }
        .status-waiting-list { background: rgba(59,130,246,0.12); color: #1e40af; }

        /* ── HALF DAY TAG ── */
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
        .days-num { font-size: 13px; font-weight: 700; color: var(--teal-bright); }

        /* ── REASON TEXT ── */
        .reason-text {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ── ACTION BUTTONS ── */
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
            font-family: 'Poppins', sans-serif;
        }

        .icon-btn:hover         { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .icon-btn.approve:hover { background: var(--green); color: #fff; border-color: var(--green); }
        .icon-btn.reject:hover  { background: var(--red);   color: #fff; border-color: var(--red); }

        /* ── ICON BTN REFRESH ── */
        .icon-btn.refresh:hover { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 56px 24px; text-align: center; }
        .empty-state i { font-size: 40px; color: var(--text-muted); opacity: 0.25; display: block; margin-bottom: 14px; }
        .empty-state h3 { font-size: 15px; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 12px; color: var(--text-muted); }

        /* ── MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(4,46,44,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active { display: flex; }

        .modal-box {
            background: #fff;
            border-radius: 14px;
            width: 100%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .modal-box.wide { max-width: 580px; }

        .modal-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h3 { font-size: 15px; font-weight: 700; color: var(--text-main); }
        .modal-subtext { font-size: 12px; color: var(--text-muted); margin-top: 3px; }

        .modal-body { padding: 18px 22px; }

        .modal-footer {
            padding: 14px 22px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Special leave info box */
        .info-box {
            background: rgba(245,158,11,0.08);
            border: 1px solid rgba(245,158,11,0.3);
            border-left: 3px solid var(--amber);
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }

        .info-box-title {
            font-size: 12px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-box p {
            font-size: 12px;
            color: #92400e;
            line-height: 1.6;
        }

        /* Char counter */
        .char-counter {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 5px;
            text-align: right;
        }

        .char-counter.warn { color: var(--red); }

        /* ── BUTTONS ── */
        .btn {
            padding: 8px 16px;
            border-radius: 7px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            text-decoration: none;
        }

        .btn-primary { background: var(--teal-bright); color: #fff; }
        .btn-primary:hover { background: var(--teal-base); color: #fff; }

        .btn-secondary { background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--teal-soft); color: var(--teal-base); }

        .btn-danger { background: var(--red); color: #fff; }
        .btn-danger:hover { background: #dc2626; }

        /* ── FORM ELEMENTS ── */
        .field-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin-bottom: 6px;
            display: block;
        }

        .textarea-field {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px;
            color: var(--text-main);
            resize: vertical;
            min-height: 100px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .textarea-field:focus {
            border-color: var(--teal-bright);
            box-shadow: 0 0 0 3px rgba(14,165,160,0.1);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .page-content { padding: 16px; }
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

    @include('components.sidebar2')

    <main class="dashboard-main">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-breadcrumb">
                <span>Admin</span>
                <span class="sep">›</span>
                <span>Leave Management</span>
                <span class="sep">›</span>
                <span class="current">Pending Approvals</span>
            </div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search applications...">
            </div>
        </div>

        <div class="page-content">

            {{-- Page Header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-clock" style="color:var(--teal-bright);margin-right:8px;"></i>
                        Pending Leave Approvals
                    </div>
                    <div class="page-subtitle">Review and approve / reject leave applications</div>
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

            {{-- Stat Card --}}
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="stat-label">Pending Applications</div>
                    <div class="stat-value">{{ $pendingApplications->count() }}</div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-hourglass-half"></i> Awaiting Your Approval
                    </div>
                    <button class="icon-btn refresh" onclick="location.reload()" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                @if($pendingApplications->count() > 0)

                <div class="scroll-hint">
                    <div class="scroll-hint-text">
                        <i class="fas fa-arrows-left-right"></i> Scroll right to see all columns
                    </div>
                    <div class="scroll-hint-btns">
                        <button class="scroll-btn" onclick="scrollTbl('left')">
                            <i class="fas fa-chevron-left"></i> Left
                        </button>
                        <button class="scroll-btn primary" onclick="scrollTbl('right')">
                            Right <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="table-wrapper" id="pendingTableWrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff Name</th>
                                <th>Type</th>
                                <th>Leave Period</th>
                                <th>Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
                            @foreach($pendingApplications as $index => $application)
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
                                    <span class="leave-badge leave-{{ strtolower(str_replace('_', '-', $application->leave_type)) }}">
                                        {{ $application->leave_type_name }}
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
                                <td>
                                    <span class="reason-text" title="{{ $application->reason }}">
                                        {{ $application->reason }}
                                    </span>
                                </td>
                                <td>
                                    @if($application->status === 'waiting_list')
                                    <span class="status-badge status-waiting-list">
                                        <i class="fas fa-hourglass-half"></i> Waiting List
                                    </span>
                                    @else
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                    @endif
                                </td>
                                <td style="font-size:11px;color:var(--text-muted);">{{ $application->created_at->format('d/m/Y, h:i A') }}</td>
                                <td>
                                    <div class="action-cell">
                                        {{-- View --}}
                                        <a href="{{ route('admin.leave.show', $application->id) }}" class="icon-btn" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Approve --}}
                                        <button type="button" class="icon-btn approve" title="Approve"
                                            onclick="approveApplication({{ $application->id }}, '{{ $application->status }}', '{{ $application->leave_type }}', '{{ $application->user->name }}')">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        {{-- Cancel (dim if leave already started/passed) --}}
                                        @php
                                            $isPast = \Carbon\Carbon::parse($application->start_date)->lte(\Carbon\Carbon::today('Asia/Kuala_Lumpur'));
                                        @endphp
                                        <form action="{{ route('leave.cancel', $application->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                class="icon-btn {{ $isPast ? 'dimmed' : 'cancel-btn' }}"
                                                title="{{ $isPast ? 'Cannot cancel — leave already started/passed' : 'Cancel Application' }}"
                                                {{ $isPast ? 'disabled' : '' }}
                                                {{ !$isPast ? 'onclick="return confirm(\'Cancel this application for ' . $application->user->name . '?\')"' : '' }}>
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <button type="button" class="icon-btn reject" title="Reject"
                                            onclick="showRejectModal({{ $application->id }}, '{{ $application->user->name }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <div class="empty-state">
                    <i class="fas fa-check-double"></i>
                    <h3>All Clear!</h3>
                    <p>No pending leave applications at this time.</p>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

{{-- ── REJECT MODAL ── --}}


{{-- ── SPECIAL LEAVE MODAL ── --}}
<div class="modal-overlay" id="specialLeaveModal">
    <div class="modal-box wide">
        <div class="modal-header">
            <h3><i class="fas fa-star" style="color:var(--amber);margin-right:6px;"></i>Approve Special Leave</h3>
            <div class="modal-subtext" id="staffNameSpecial"></div>
        </div>
        <form id="specialLeaveForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="fas fa-info-circle"></i> Special Leave Approval
                    </div>
                    <p>
                        You are approving a <strong>Special Leave</strong> application.
                        Please provide a <strong>mandatory remark</strong> explaining why this Special Leave is approved.
                        This is for documentation and audit purposes.
                    </p>
                </div>
                <label class="field-label">Approval Remark <span style="color:var(--red);">*</span></label>
                <textarea class="textarea-field" id="approval_note" name="approval_note" rows="5" required maxlength="500"
                    placeholder="Example: Approved for quarantine period as recommended by healthcare provider. Staff will work from home when able during this period."></textarea>
                <div class="char-counter" id="charCountWrapper"><span id="charCount">0</span>/500 characters</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeSpecialLeaveModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Approve with Remark
                </button>
            </div>
        </form>
    </div>
</div>

<script>
/* ── SCROLL ── */
function scrollTbl(dir) {
    document.getElementById('pendingTableWrapper').scrollBy({ left: dir === 'left' ? -400 : 400, behavior: 'smooth' });
}

/* ── APPROVE ── */
function approveApplication(id, status, leaveType, staffName) {
    if (leaveType === 'SL') {
        showSpecialLeaveModal(id, staffName);
        return;
    }

    let message = status === 'waiting_list'
        ? 'Approve this WAITING LIST application as SPECIAL CASE?\n\nThis will approve the 3rd person on this date.\nMake sure you have met with the staff member first.'
        : 'Approve this leave application?\n\nThis will:\n✓ Deduct leave balance (if applicable)\n✓ Update daily count\n✓ Mark as approved';

    if (confirm(message)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/leave/approve/' + id;
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}

/* ── SPECIAL LEAVE MODAL ── */
function showSpecialLeaveModal(id, staffName) {
    document.getElementById('specialLeaveForm').action = '/admin/leave/approve/' + id;
    document.getElementById('staffNameSpecial').textContent = 'Approving Special Leave for: ' + staffName;
    document.getElementById('approval_note').value = '';
    updateCharCount();
    document.getElementById('specialLeaveModal').classList.add('active');
}

function closeSpecialLeaveModal() {
    document.getElementById('specialLeaveModal').classList.remove('active');
    document.getElementById('approval_note').value = '';
}

function updateCharCount() {
    const len = document.getElementById('approval_note').value.length;
    document.getElementById('charCount').textContent = len;
    const wrapper = document.getElementById('charCountWrapper');
    wrapper.classList.toggle('warn', len > 450);
}

/* ── REJECT MODAL ── */
function showRejectModal(id, staffName) {
    if (confirm('Reject leave application for ' + staffName + '?\n\nThis action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/leave/reject/' + id;
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }
}

/* ── CLICK OUTSIDE CLOSE ── */
window.addEventListener('click', function (e) {
    if (e.target.id === 'rejectModal')       closeRejectModal();
    if (e.target.id === 'specialLeaveModal') closeSpecialLeaveModal();
});

document.addEventListener('DOMContentLoaded', function () {
    /* Search */
    const searchInput = document.getElementById('searchInput');
    const tableBody   = document.getElementById('staffTableBody');
    if (searchInput && tableBody) {
        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            Array.from(tableBody.rows).forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    }

    /* Auto-dismiss alerts */
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

    /* Table scroll shadow */
    const wrapper = document.getElementById('pendingTableWrapper');
    if (wrapper) {
        const upd = () => {
            const atStart = wrapper.scrollLeft === 0;
            const atEnd   = wrapper.scrollLeft >= wrapper.scrollWidth - wrapper.clientWidth - 1;
            wrapper.style.boxShadow = atStart && atEnd ? 'none'
                : atStart ? 'inset -8px 0 12px -8px rgba(4,46,44,0.12)'
                : atEnd   ? 'inset 8px 0 12px -8px rgba(4,46,44,0.12)'
                : 'inset 8px 0 12px -8px rgba(4,46,44,0.12), inset -8px 0 12px -8px rgba(4,46,44,0.12)';
        };
        wrapper.addEventListener('scroll', upd);
        upd();
    }

    /* Char counter */
    const approvalNote = document.getElementById('approval_note');
    if (approvalNote) approvalNote.addEventListener('input', updateCharCount);
});
</script>
</body>
</html>
