{{-- C:\laragon\www\om_system\resources\views\admin\leave\all-applications.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Applications | O&M HRCare</title>
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

        /* ── SEARCH BOX (topbar right) ── */
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

        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

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
        .stat-icon.amber  { background: rgba(245,158,11,0.1); color: var(--amber); }
        .stat-icon.green  { background: rgba(34,197,94,0.1);  color: var(--green); }

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

        /* ── FILTER CARD ── */
        .filter-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
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
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 14px;
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

        .form-input, .form-select {
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

        .form-input:focus, .form-select:focus {
            border-color: var(--teal-bright);
            box-shadow: 0 0 0 3px rgba(14,165,160,0.1);
        }

        .form-hint {
            font-size: 10px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .filter-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

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

        .btn-primary {
            background: var(--teal-bright);
            color: #fff;
        }

        .btn-primary:hover { background: var(--teal-base); }

        .btn-secondary {
            background: var(--off-white);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover { background: var(--teal-soft); color: var(--teal-base); }

        .btn-danger {
            background: var(--red);
            color: #fff;
        }

        .btn-danger:hover { background: #dc2626; }

        /* ── ACTIVE FILTERS ── */
        .active-filters {
            background: rgba(14,165,160,0.06);
            border: 1px solid var(--teal-border);
            border-left: 3px solid var(--teal-bright);
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .active-filters-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--teal-base);
            display: flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
        }

        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            background: var(--teal-bright);
            color: #fff;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .filter-tag-remove {
            cursor: pointer;
            opacity: 0.8;
            transition: opacity .2s;
            background: none;
            border: none;
            color: #fff;
            padding: 0;
            font-size: 11px;
            line-height: 1;
        }

        .filter-tag-remove:hover { opacity: 1; }

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
        }

        .icon-btn:hover            { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }
        .icon-btn.approve:hover    { background: var(--green); color: #fff; border-color: var(--green); }
        .icon-btn.reject:hover     { background: var(--red);   color: #fff; border-color: var(--red); }
        .icon-btn.download:hover   { background: var(--blue);  color: #fff; border-color: var(--blue); }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 48px 24px; text-align: center; }
        .empty-state i { font-size: 40px; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 12px; }
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
            max-width: 480px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

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

        .field-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin-bottom: 6px;
            display: block;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1400px) {
            .filter-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
            .filter-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .filter-grid { grid-template-columns: 1fr; }
            .page-content { padding: 16px; }
            .page-header { flex-direction: column; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
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
                <span class="current">All Applications</span>
            </div>
        </div>

        <div class="page-content">

            {{-- Page Header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-list-alt" style="color:var(--teal-bright);margin-right:8px;"></i>
                        All Leave Applications
                    </div>
                    <div class="page-subtitle">View and manage all staff leave applications</div>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search staff name...">
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
                    <div class="stat-icon purple"><i class="fas fa-list"></i></div>
                    <div>
                        <div class="stat-label">Total Applications</div>
                        <div class="stat-value">{{ $applications->count() }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
                    <div>
                        <div class="stat-label">Pending Approval</div>
                        <div class="stat-value">{{ $applications->where('status', 'pending')->count() }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <div class="stat-label">Approved</div>
                        <div class="stat-value">{{ $applications->where('status', 'approved')->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="filter-card">
                <div class="filter-card-header">
                    <div class="filter-card-title">
                        <i class="fas fa-filter"></i> Filter Applications
                    </div>
                </div>
                <div class="filter-card-body">
                    <form method="GET" action="{{ route('admin.leave.all-applications') }}" id="filterForm">
                        <div class="filter-grid">

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-user"></i> Staff Name</label>
                                <input
                                    type="text"
                                    class="form-input"
                                    id="staff_name"
                                    name="staff_name"
                                    placeholder="Type staff name to search..."
                                    value="{{ request('staff_name') }}"
                                    autocomplete="off"
                                >
                                <span class="form-hint"><i class="fas fa-info-circle"></i> e.g. "Ahmad", "Siti"</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-filter"></i> Status</label>
                                <select class="form-select" id="status" name="status" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Status</option>
                                    <option value="pending"               {{ request('status') == 'pending'               ? 'selected' : '' }}>Pending Approval</option>
                                    <option value="waiting_list"          {{ request('status') == 'waiting_list'          ? 'selected' : '' }}>Waiting List</option>
                                    <option value="approved"              {{ request('status') == 'approved'              ? 'selected' : '' }}>Approved</option>
                                    <option value="special_case_approved" {{ request('status') == 'special_case_approved' ? 'selected' : '' }}>Special Case Approved</option>
                                    <option value="rejected"              {{ request('status') == 'rejected'              ? 'selected' : '' }}>Rejected</option>
                                    <option value="cancelled"             {{ request('status') == 'cancelled'             ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-tag"></i> Leave Type</label>
                                <select class="form-select" id="leave_type" name="leave_type" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Types</option>
                                    <option value="AL"          {{ request('leave_type') == 'AL'          ? 'selected' : '' }}>AL - Annual Leave</option>
                                    <option value="HALF_DAY_AL" {{ request('leave_type') == 'HALF_DAY_AL' ? 'selected' : '' }}>AL (Half Day)</option>
                                    <option value="EL"          {{ request('leave_type') == 'EL'          ? 'selected' : '' }}>EL - Emergency Leave</option>
                                    <option value="HALF_DAY_EL" {{ request('leave_type') == 'HALF_DAY_EL' ? 'selected' : '' }}>EL (Half Day)</option>
                                    <option value="MC"          {{ request('leave_type') == 'MC'          ? 'selected' : '' }}>MC - Medical Leave</option>
                                    <option value="CL"          {{ request('leave_type') == 'CL'          ? 'selected' : '' }}>CL - Compassionate Leave</option>
                                    <option value="WFH"         {{ request('leave_type') == 'WFH'         ? 'selected' : '' }}>WFH - Work From Home</option>
                                    <option value="ML"          {{ request('leave_type') == 'ML'          ? 'selected' : '' }}>ML - Maternity Leave</option>
                                    <option value="PL"          {{ request('leave_type') == 'PL'          ? 'selected' : '' }}>PL - Paternity Leave</option>
                                    <option value="RL"          {{ request('leave_type') == 'RL'          ? 'selected' : '' }}>RL - Replacement Leave</option>
                                    <option value="MRL"         {{ request('leave_type') == 'MRL'         ? 'selected' : '' }}>MRL - Married Leave</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar"></i> Bulan</label>
                                <select class="form-select" id="month" name="month" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Months</option>
                                    @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar-alt"></i> Year</label>
                                <select class="form-select" id="year" name="year" onchange="document.getElementById('filterForm').submit()">
                                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                    <option value="{{ $y }}" {{ (request('year', date('Y')) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary" id="filterSubmitBtn">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                            <a href="{{ route('admin.leave.all-applications') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Active Filters --}}
            @if(request()->hasAny(['staff_name', 'status', 'leave_type', 'month']))
            <div class="active-filters">
                <div class="active-filters-label">
                    <i class="fas fa-filter"></i> Active Filters:
                </div>

                @if(request('staff_name'))
                <span class="filter-tag">
                    <i class="fas fa-user"></i> Name: "{{ request('staff_name') }}"
                    <button class="filter-tag-remove" onclick="removeFilter('staff_name')"><i class="fas fa-times"></i></button>
                </span>
                @endif

                @if(request('status'))
                <span class="filter-tag">
                    <i class="fas fa-info-circle"></i> Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                    <button class="filter-tag-remove" onclick="removeFilter('status')"><i class="fas fa-times"></i></button>
                </span>
                @endif

                @if(request('leave_type'))
                <span class="filter-tag">
                    <i class="fas fa-tag"></i> Type: {{ request('leave_type') }}
                    <button class="filter-tag-remove" onclick="removeFilter('leave_type')"><i class="fas fa-times"></i></button>
                </span>
                @endif

                @if(request('month'))
                <span class="filter-tag">
                    <i class="fas fa-calendar"></i> Month: {{ date('F', mktime(0, 0, 0, request('month'), 1)) }}
                    <button class="filter-tag-remove" onclick="removeFilter('month')"><i class="fas fa-times"></i></button>
                </span>
                @endif

                <a href="{{ route('admin.leave.all-applications') }}" class="btn btn-secondary" style="padding:4px 10px;font-size:11px;">
                    <i class="fas fa-times-circle"></i> Clear All
                </a>
            </div>
            @endif

            {{-- Applications Table --}}
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-table"></i> Applications List
                    </div>
                    <button class="icon-btn" onclick="location.reload()" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                @if($applications->count() > 0)

                <div class="scroll-hint">
                    <div class="scroll-hint-text">
                        <i class="fas fa-arrows-left-right"></i> Scroll right to see all columns
                    </div>
                    <div class="scroll-hint-btns">
                        <button class="scroll-btn" onclick="scrollTbl('appTable','left')">
                            <i class="fas fa-chevron-left"></i> Left
                        </button>
                        <button class="scroll-btn primary" onclick="scrollTbl('appTable','right')">
                            Right <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="table-wrapper" id="appTable">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff</th>
                                <th>Leave Type</th>
                                <th>Leave Period</th>
                                <th>Hari</th>
                                <th>Applied</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
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
                                        <i class="fas {{ $st['icon'] }}"></i> {{ $st['label'] }}
                                    </span>
                                </td>
                                <td>
                                    @if(in_array($application->status, ['pending','waiting_list']))
                                        <span style="font-size:11px;color:var(--text-muted);">Waiting for approval</span>
                                    @elseif($application->status === 'cancelled' && $application->approvedBy)
                                        @if($application->approvedBy->id === $application->user_id)
                                            <div style="font-size:12px;font-weight:600;color:#6b7280;">{{ $application->approvedBy->name }}</div>
                                            <div style="font-size:11px;color:var(--text-muted);">Self Cancel • {{ $application->approved_at->format('d/m/Y') }}</div>
                                        @else
                                            <div style="font-size:12px;font-weight:600;color:#6b7280;">{{ $application->approvedBy->name }}</div>
                                            <div style="font-size:11px;color:var(--text-muted);">Cancelled • {{ $application->approved_at->format('d/m/Y') }}</div>
                                        @endif
                                    @elseif($application->status === 'rejected' && $application->approvedBy)
                                        <div style="font-size:12px;font-weight:600;color:#991b1b;">{{ $application->approvedBy->name }}</div>
                                        <div style="font-size:11px;color:var(--text-muted);">Rejected • {{ $application->approved_at->format('d/m/Y') }}</div>
                                    @elseif($application->approvedBy)
                                        <div style="font-size:12px;font-weight:600;">{{ $application->approvedBy->name }}</div>
                                        <div style="font-size:11px;color:var(--text-muted);">{{ $application->approved_at->format('d/m/Y') }}</div>
                                    @else
                                        <span style="font-size:11px;color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-cell">
                                        {{-- View --}}
                                        <a href="{{ route('admin.leave.show', $application->id) }}" class="icon-btn" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Download Attachment --}}
                                        @if($application->attachment)
                                        <a href="{{ route('admin.leave.download-attachment', $application->id) }}" class="icon-btn download" title="Download Attachment">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @endif

                                        @if($application->status === 'pending' || $application->status === 'waiting_list')
                                        @php
                                            $isPast = \Carbon\Carbon::parse($application->start_date)->lte(\Carbon\Carbon::today('Asia/Kuala_Lumpur'));
                                        @endphp

                                        {{-- Approve --}}
                                        <form action="{{ route('admin.leave.approve', $application->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="icon-btn approve" title="Approve"
                                                onclick="return confirm('{{ $application->status === 'waiting_list' ? 'Approve as SPECIAL CASE?' : 'Approve leave for ' . $application->user->name . '?' }}')">
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Applications Found</h3>
                    <p>Try adjusting your filters or reset to view all applications.</p>
                </div>
                @endif
            </div>

        </div>{{-- end page-content --}}
    </main>
</div>

                {{-- ── REJECT MODAL ── --}}


<script>
/* ── MODAL ── */
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

/* ── SCROLL TABLE ── */
function scrollTbl(id, dir) {
    document.getElementById(id).scrollBy({ left: dir === 'left' ? -400 : 400, behavior: 'smooth' });
}

/* ── REMOVE FILTER TAG ── */
function removeFilter(filterName) {
    const url = new URL(window.location.href);
    url.searchParams.delete(filterName);
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function () {

    /* Quick search (client-side) */
    const searchInput = document.getElementById('searchInput');
    const tableBody   = document.getElementById('staffTableBody');

    if (searchInput && tableBody) {
        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            Array.from(tableBody.rows).forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
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
    const wrapper = document.getElementById('appTable');
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

    /* Auto-submit name filter with debounce */
    let searchTimeout;
    const staffNameInput  = document.getElementById('staff_name');
    const filterSubmitBtn = document.getElementById('filterSubmitBtn');

    if (staffNameInput && filterSubmitBtn) {
        staffNameInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const originalHtml = filterSubmitBtn.innerHTML;
            filterSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
            filterSubmitBtn.disabled = true;

            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    document.getElementById('filterForm').submit();
                } else {
                    filterSubmitBtn.innerHTML = originalHtml;
                    filterSubmitBtn.disabled  = false;
                }
            }, 800);
        });
    }
});
</script>
</body>
</html>
