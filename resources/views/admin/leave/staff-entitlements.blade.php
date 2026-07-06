{{-- C:\laragon\www\om_system\resources\views\admin\leave\staff-entitlements.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staff Leave Balances | O&M HRCare</title>
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
            --red:    #ef4444;
            --amber:  #f59e0b;
            --green:  #22c55e;
            --blue:   #3b82f6;
            --purple: #7c3aed;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--off-white); color: var(--text-main); font-size: 13px; }
        .dashboard-layout { display: flex; min-height: 100vh; }
        .dashboard-main   { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        /* ── TOPBAR ── */
        .topbar {
            height: 60px; background: #fff; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; position: sticky; top: 0; z-index: 100;
        }
        .topbar-breadcrumb { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
        .topbar-breadcrumb .sep     { opacity: .5; }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 600; }

        /* ── PAGE ── */
        .page-content  { padding: 24px 28px; flex: 1; }
        .page-header   { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; gap: 16px; flex-wrap: wrap; }
        .page-title    { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .page-subtitle { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ── BUTTON ── */
        .btn { padding: 8px 16px; border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 6px; transition: all .2s; text-decoration: none; }
        .btn-primary       { background: var(--teal-bright); color: #fff; }
        .btn-primary:hover { background: var(--teal-base);   color: #fff; }
        .btn-sm { padding: 6px 12px; font-size: 11px; }
        .btn-warning { background: var(--amber); color: #fff; }
        .btn-warning:hover { background: #d97706; color: #fff; }

        /* ── STAT CARDS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card  { background: #fff; border-radius: 12px; border: 1px solid var(--border); padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon  { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .stat-icon.blue   { background: rgba(59,130,246,0.1);  color: var(--blue); }
        .stat-icon.purple { background: rgba(124,58,237,0.1);  color: var(--purple); }
        .stat-icon.red    { background: rgba(239,68,68,0.1);   color: var(--red); }
        .stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); margin-bottom: 4px; }
        .stat-value { font-size: 28px; font-weight: 700; color: var(--text-main); line-height: 1; }

        /* ── FILTER CARD ── */
        .filter-card        { background: #fff; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: 20px; overflow: hidden; }
        .filter-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); }
        .filter-card-title  { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
        .filter-card-title i { color: var(--teal-bright); }
        .filter-card-body   { padding: 16px 20px; }
        .filter-grid        { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: end; }
        .form-group  { display: flex; flex-direction: column; gap: 5px; }
        .form-label  { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
        .form-label i { color: var(--teal-bright); }
        .form-input, .form-select { padding: 8px 11px; border: 1px solid var(--border); border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 12px; color: var(--text-main); background: #fff; outline: none; transition: border-color .2s, box-shadow .2s; width: 100%; }
        .form-input:focus, .form-select:focus { border-color: var(--teal-bright); box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }

        /* ── TABLE CONTAINER ── */
        .table-container { background: #fff; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 16px; }
        .table-header    { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-title     { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); display: flex; align-items: center; gap: 8px; }
        .table-title i   { color: var(--teal-bright); }
        .icon-btn { width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--border); background: #fff; color: var(--text-muted); font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all .2s; }
        .icon-btn:hover { background: var(--teal-bright); color: #fff; border-color: var(--teal-bright); }

        /* ── TABLE WRAPPER ── */
        .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; scroll-behavior: smooth; }
        .table-wrapper::-webkit-scrollbar       { height: 6px; }
        .table-wrapper::-webkit-scrollbar-track  { background: var(--off-white); }
        .table-wrapper::-webkit-scrollbar-thumb  { background: var(--teal-bright); border-radius: 6px; }

        /* ── DATA TABLE ── */
        .data-table { width: 100%; min-width: 900px; border-collapse: collapse; }

        .data-table thead tr.group-row th { padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; border-bottom: 1px solid var(--border); white-space: nowrap; }
        .data-table thead tr.group-row th.col-plain { background: var(--off-white); color: var(--text-muted); }
        .data-table thead tr.group-row th.col-al    { background: rgba(14,165,160,0.10); color: var(--teal-base); border-left: 2px solid var(--teal-bright); }
        .data-table thead tr.group-row th.col-mc    { background: rgba(239,68,68,0.08);  color: #b91c1c;         border-left: 2px solid var(--red); }

        .data-table thead tr.sub-row th { padding: 9px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); background: var(--off-white); border-bottom: 1px solid var(--border); text-align: center; white-space: nowrap; }
        .data-table thead tr.sub-row th.sub-al { background: rgba(14,165,160,0.06); border-left: 1px solid rgba(14,165,160,0.2); }
        .data-table thead tr.sub-row th.sub-mc { background: rgba(239,68,68,0.05);  border-left: 1px solid rgba(239,68,68,0.15); }

        .data-table tbody td { padding: 12px 14px; font-size: 12px; color: var(--text-main); border-bottom: 1px solid var(--border); text-align: center; white-space: nowrap; }
        .data-table tbody td.left-align { text-align: left; }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover { background: rgba(14,165,160,0.03); }
        .data-table tbody td.cell-al { background: rgba(14,165,160,0.04); border-left: 1px solid rgba(14,165,160,0.10); }
        .data-table tbody td.cell-mc { background: rgba(239,68,68,0.03);  border-left: 1px solid rgba(239,68,68,0.10); }

        .data-table tfoot td { padding: 12px 14px; font-size: 12px; font-weight: 700; border-top: 2px solid var(--border); text-align: center; background: var(--off-white); white-space: nowrap; }
        .data-table tfoot td.cell-al { background: rgba(14,165,160,0.07); border-left: 1px solid rgba(14,165,160,0.10); }
        .data-table tfoot td.cell-mc { background: rgba(239,68,68,0.05);  border-left: 1px solid rgba(239,68,68,0.10); }

        /* ── STAFF CELL ── */
        .staff-cell { display: flex; align-items: center; gap: 10px; }
        .staff-avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--teal-base); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .staff-name-text { font-weight: 600; font-size: 12px; }
        .staff-pos-text  { font-size: 11px; color: var(--text-muted); }

        /* ── BALANCE NUMBERS ── */
        .bal-healthy { color: var(--green);       font-weight: 700; font-size: 13px; }
        .bal-low     { color: var(--red);          font-weight: 700; font-size: 13px; }
        .bal-used-al { color: var(--teal-bright);  font-weight: 700; }
        .bal-used-mc { color: #dc2626;             font-weight: 700; }

        /* ── LEGEND ── */
        .legend-card  { background: #fff; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); padding: 16px 20px; }
        .legend-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
        .legend-title i { color: var(--teal-bright); }
        .legend-grid  { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; }
        .legend-item  { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .legend-dot   { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

        /* ── EMPTY STATE ── */
        .empty-state    { padding: 56px 24px; text-align: center; }
        .empty-state i  { font-size: 40px; color: var(--text-muted); opacity: 0.25; display: block; margin-bottom: 14px; }
        .empty-state h3 { font-size: 15px; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 12px; color: var(--text-muted); }

        /* ── MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(4, 46, 44, 0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(4, 46, 44, 0.3);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease-out;
        }
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .modal-title i {
            color: var(--amber);
        }
        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: var(--off-white);
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .modal-close:hover {
            background: var(--red);
            color: #fff;
        }
        .modal-body {
            padding: 24px;
        }
        .modal-info {
            background: var(--teal-soft);
            border: 1px solid var(--teal-border);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .modal-info i {
            color: var(--teal-bright);
            font-size: 16px;
            margin-top: 2px;
        }
        .modal-info-text {
            font-size: 11px;
            color: var(--teal-dark);
            line-height: 1.5;
        }
        .modal-form-group {
            margin-bottom: 18px;
        }
        .modal-form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .modal-form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: var(--text-main);
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .modal-form-input:focus {
            border-color: var(--teal-bright);
            box-shadow: 0 0 0 3px rgba(14, 165, 160, 0.1);
        }
        .modal-form-input:disabled {
            background: var(--off-white);
            color: var(--text-muted);
            cursor: not-allowed;
        }
        .modal-form-hint {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .modal-form-hint i {
            font-size: 10px;
        }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .btn-cancel {
            background: var(--off-white);
            color: var(--text-muted);
        }
        .btn-cancel:hover {
            background: #e0e7e7;
            color: var(--text-main);
        }

        /* ── ALERT MESSAGES ── */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .alert i {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .alert-message {
            font-size: 12px;
            line-height: 1.5;
            font-weight: 500;
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #166534;
        }
        .alert-success i {
            color: var(--green);
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #991b1b;
        }
        .alert-error i {
            color: var(--red);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px)  { .stats-grid { grid-template-columns: 1fr 1fr; } .filter-grid { grid-template-columns: 1fr; } }
        @media (max-width: 560px)  { .stats-grid { grid-template-columns: 1fr; } .page-content { padding: 16px; } .page-header { flex-direction: column; } }
    </style>
</head>

<body>
<div class="dashboard-layout">

    @include('components.sidebar2')

    <main class="dashboard-main">

        <div class="topbar">
            <div class="topbar-breadcrumb">
                <span>Admin</span>
                <span class="sep">›</span>
                <span>Leave Management</span>
                <span class="sep">›</span>
                <span class="current">Staff Leave Balances</span>
            </div>
        </div>

        <div class="page-content">

            {{-- SUCCESS/ERROR MESSAGES --}}
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <div class="alert-message">{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div class="alert-message">{{ session('error') }}</div>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="alert-message">
                    <strong>Validation Error:</strong>
                    <ul style="margin: 6px 0 0 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-users" style="color:var(--teal-bright);margin-right:8px;"></i>Staff Leave Balances
                    </div>
                    <div class="page-subtitle">View all staff leave entitlements and balances</div>
                </div>
                <a href="{{ route('admin.leave.intern-entitlements') }}" class="btn btn-primary">
                    <i class="fas fa-user-graduate"></i> View Intern Entitlements
                </a>
            </div>

            {{-- Stat Cards --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="stat-label">Total Staff</div>
                        <div class="stat-value">{{ $staff->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-umbrella-beach"></i></div>
                    <div>
                        <div class="stat-label">Total AL Used</div>
                        <div class="stat-value">{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->annual_leave_used ?? 0; }) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-notes-medical"></i></div>
                    <div>
                        <div class="stat-label">Total MC Used</div>
                        <div class="stat-value">{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->medical_leave_used ?? 0; }) }}</div>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="filter-card">
                <div class="filter-card-header">
                    <div class="filter-card-title"><i class="fas fa-filter"></i> Filter</div>
                </div>
                <div class="filter-card-body">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-search"></i> Search Staff Name</label>
                            <input type="text" class="form-input" id="searchInput" placeholder="Type staff name...">
                        </div>
                        <form method="GET" action="{{ route('admin.leave.staff-entitlements') }}">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar-alt"></i> Select Year</label>
                                <select class="form-select" id="year" name="year" onchange="this.form.submit()">
                                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title"><i class="fas fa-table"></i> Leave Balances — Year {{ $year }}</div>
                    <button class="icon-btn" onclick="location.reload()" title="Refresh"><i class="fas fa-sync-alt"></i></button>
                </div>

                @if($staff->count() > 0)
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr class="group-row">
                                <th class="col-plain left-align" rowspan="2">#</th>
                                <th class="col-plain" rowspan="2" style="text-align:left;">Staff</th>
                                <th class="col-plain" rowspan="2" style="text-align:left;">Position</th>
                                <th class="col-al" colspan="3">Annual Leave (AL)</th>
                                <th class="col-mc" colspan="3">Medical Leave (MC)</th>
                                <th class="col-plain" rowspan="2">Action</th>
                            </tr>
                            <tr class="sub-row">
                                <th class="sub-al">Total</th>
                                <th class="sub-al">Used</th>
                                <th class="sub-al">Balance</th>
                                <th class="sub-mc">Total</th>
                                <th class="sub-mc">Used</th>
                                <th class="sub-mc">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
                            @foreach($staff as $index => $member)
                            @php $entitlement = $member->leaveEntitlements->where('year', $year)->first(); @endphp
                            <tr>
                                <td class="left-align">{{ $index + 1 }}</td>
                                <td class="left-align">
                                    <div class="staff-cell">
                                        <div class="staff-avatar">{{ substr($member->name, 0, 1) }}</div>
                                        <div class="staff-name-text">{{ $member->name }}</div>
                                    </div>
                                </td>
                                <td class="left-align"><span class="staff-pos-text">{{ $member->position ?? 'N/A' }}</span></td>
                                <td class="cell-al"><strong>{{ $entitlement->annual_leave_total }}</strong></td>
                                <td class="cell-al"><span class="bal-used-al">{{ $entitlement->annual_leave_used }}</span></td>
                                <td class="cell-al"><span class="{{ $entitlement->annual_leave_balance <= 3 ? 'bal-low' : 'bal-healthy' }}">{{ $entitlement->annual_leave_balance }}</span></td>
                                <td class="cell-mc"><strong>{{ $entitlement->medical_leave_total }}</strong></td>
                                <td class="cell-mc"><span class="bal-used-mc">{{ $entitlement->medical_leave_used }}</span></td>
                                <td class="cell-mc"><span class="{{ $entitlement->medical_leave_balance <= 3 ? 'bal-low' : 'bal-healthy' }}">{{ $entitlement->medical_leave_balance }}</span></td>
                                <td>
                                    <button
                                        class="btn btn-sm btn-warning edit-entitlement-btn"
                                        data-entitlement-id="{{ $entitlement->id }}"
                                        data-staff-name="{{ $member->name }}"
                                        data-year="{{ $year }}"
                                        data-al-total="{{ $entitlement->annual_leave_total }}"
                                        data-al-used="{{ $entitlement->annual_leave_used }}"
                                        data-mc-total="{{ $entitlement->medical_leave_total }}"
                                        data-mc-used="{{ $entitlement->medical_leave_used }}"
                                    >
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;padding-right:14px;color:var(--text-muted);font-size:11px;">TOTAL</td>
                                <td class="cell-al"><strong>{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->annual_leave_total ?? 0; }) }}</strong></td>
                                <td class="cell-al"><span class="bal-used-al">{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->annual_leave_used ?? 0; }) }}</span></td>
                                <td class="cell-al"><span class="bal-healthy">{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->annual_leave_balance ?? 0; }) }}</span></td>
                                <td class="cell-mc"><strong>{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->medical_leave_total ?? 0; }) }}</strong></td>
                                <td class="cell-mc"><span class="bal-used-mc">{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->medical_leave_used ?? 0; }) }}</span></td>
                                <td class="cell-mc"><span class="bal-healthy">{{ $staff->sum(function($s) { return $s->leaveEntitlements->first()->medical_leave_balance ?? 0; }) }}</span></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h3>No Staff Found</h3>
                    <p>There are no active staff members in the system.</p>
                </div>
                @endif
            </div>

            {{-- Legend --}}
            <div class="legend-card">
                <div class="legend-title"><i class="fas fa-info-circle"></i> Legend</div>
                <div class="legend-grid">
                    <div class="legend-item"><span class="legend-dot" style="background:var(--green);"></span> Balance &gt; 3 days (Healthy)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--red);"></span> Balance ≤ 3 days (Low)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--teal-bright);"></span> Annual Leave (AL)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:#dc2626;"></span> Medical Leave (MC)</div>
                </div>
            </div>

        </div>
    </main>
</div>

{{--  EDIT ENTITLEMENT MODAL --}}
<div class="modal-overlay" id="editEntitlementModal">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">
                <i class="fas fa-edit"></i>
                Edit Leave Entitlement
            </div>
            <button type="button" class="modal-close" onclick="closeEditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editEntitlementForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-info">
                    <i class="fas fa-info-circle"></i>
                    <div class="modal-info-text">
                        <strong>Note:</strong> You can only edit the <strong>Total</strong> entitlement.
                        The <strong>Used</strong> values cannot be changed manually — they are automatically calculated from approved leave applications.
                    </div>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Staff Name</label>
                    <input type="text" class="modal-form-input" id="modalStaffName" disabled>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Year</label>
                    <input type="text" class="modal-form-input" id="modalYear" disabled>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Annual Leave Total</label>
                    <input type="number" class="modal-form-input" id="modalALTotal" name="annual_leave_total" min="0" max="365" required>
                    <div class="modal-form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Current Used: <strong id="modalALUsed"></strong> days</span>
                    </div>
                </div>

                <div class="modal-form-group">
                    <label class="modal-form-label">Medical Leave Total</label>
                    <input type="number" class="modal-form-input" id="modalMCTotal" name="medical_leave_total" min="0" max="365" required>
                    <div class="modal-form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Current Used: <strong id="modalMCUsed"></strong> days</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" onclick="closeEditModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableBody   = document.getElementById('staffTableBody');
    if (searchInput && tableBody) {
        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            Array.from(tableBody.rows).forEach(row => {
                const nameCell = row.getElementsByTagName('td')[1];
                if (nameCell) row.style.display = nameCell.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    }

    // Edit button click handler
    const editButtons = document.querySelectorAll('.edit-entitlement-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const entitlementId = this.dataset.entitlementId;
            const staffName = this.dataset.staffName;
            const year = this.dataset.year;
            const alTotal = this.dataset.alTotal;
            const alUsed = this.dataset.alUsed;
            const mcTotal = this.dataset.mcTotal;
            const mcUsed = this.dataset.mcUsed;

            // Populate modal
            document.getElementById('modalStaffName').value = staffName;
            document.getElementById('modalYear').value = year;
            document.getElementById('modalALTotal').value = alTotal;
            document.getElementById('modalALUsed').textContent = alUsed;
            document.getElementById('modalMCTotal').value = mcTotal;
            document.getElementById('modalMCUsed').textContent = mcUsed;

            // Set form action
            const form = document.getElementById('editEntitlementForm');
            form.action = "{{ route('admin.leave.update-entitlement', ':id') }}".replace(':id', entitlementId);

            // Show modal
            document.getElementById('editEntitlementModal').classList.add('active');
        });
    });

    // Close modal when clicking overlay
    document.getElementById('editEntitlementModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
});

function closeEditModal() {
    document.getElementById('editEntitlementModal').classList.remove('active');
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});
</script>
</body>
</html>
