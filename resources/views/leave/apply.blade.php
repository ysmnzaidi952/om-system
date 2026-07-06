{{-- C:\laragon\www\om_system\resources\views\leave\apply.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Apply Leave | O&M HRCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f0fafa; color: #0a2e2c; font-size: 14px; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        /* LAYOUT */
        .lv-layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .lv-sidebar {
            width: 240px; min-height: 100vh; background: #042e2c;
            display: flex; flex-direction: column; flex-shrink: 0;
            position: sticky; top: 0; height: 100vh; overflow-y: auto;
        }
        .lv-sidebar::-webkit-scrollbar { width: 4px; }
        .lv-sidebar::-webkit-scrollbar-thumb { background: rgba(14,165,160,0.2); border-radius: 2px; }
        .lv-sb-header { padding: 32px 24px 24px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .lv-sb-brand  { font-size: 24px; font-weight: 700; letter-spacing: 3px; color: #0EA5A0; line-height: 1; margin-bottom: 10px; }
        .lv-sb-role   { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: rgba(245,243,239,0.35); margin-bottom: 4px; }
        .lv-sb-user   { font-size: 13px; font-weight: 500; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .lv-sb-nav    { flex: 1; padding: 16px 0; }
        .lv-sb-nav ul { list-style: none; margin: 0; padding: 0; }
        .lv-sb-nav li a {
            display: flex; align-items: center; gap: 12px; padding: 12px 24px;
            font-size: 13px; color: rgba(245,243,239,0.5); letter-spacing: 0.3px; transition: all 0.2s; position: relative;
        }
        .lv-sb-nav li a i { font-size: 13px; width: 16px; text-align: center; flex-shrink: 0; color: rgba(245,243,239,0.3); transition: color 0.2s; }
        .lv-sb-nav li a:hover { color: #fff; background: rgba(14,165,160,0.08); padding-left: 28px; }
        .lv-sb-nav li a:hover i { color: #0EA5A0; }
        .lv-sb-nav li.active a { color: #fff; background: rgba(14,165,160,0.14); font-weight: 500; }
        .lv-sb-nav li.active a::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: #0EA5A0; border-radius: 0 2px 2px 0; }
        .lv-sb-nav li.active a i { color: #0EA5A0; }
        .lv-sb-nav li.lv-logout { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.06); }
        .lv-sb-nav li.lv-logout a { color: rgba(245,243,239,0.3); }
        .lv-sb-nav li.lv-logout a:hover { color: #f87171; background: rgba(239,68,68,0.08); padding-left: 28px; }
        .lv-sb-nav li.lv-logout a:hover i { color: #f87171; }

        /* MAIN */
        .lv-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* TOPBAR */
        .lv-topbar {
            background: #fff; border-bottom: 1px solid rgba(14,165,160,0.15);
            padding: 0 24px; height: 56px; display: flex; align-items: center;
            position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }
        .lv-breadcrumb { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #4a7a76; }
        .lv-breadcrumb a { color: #4a7a76; transition: color 0.2s; }
        .lv-breadcrumb a:hover { color: #0EA5A0; }
        .lv-breadcrumb .lv-current { color: #0a2e2c; font-weight: 600; }
        .lv-breadcrumb .lv-sep { opacity: 0.4; }

        /* CONTENT */
        .lv-content { padding: 22px 24px; flex: 1; max-width: 920px; }

        /* ALERTS */
        .lv-alert { display: flex; align-items: flex-start; gap: 9px; padding: 11px 14px; border-radius: 8px; margin-bottom: 12px; font-size: 13px; }
        .lv-alert-error   { background: rgba(239,68,68,0.08);  color: #dc2626; border: 1px solid rgba(239,68,68,0.2);  border-left: 3px solid #ef4444; }
        .lv-alert-warning { background: rgba(245,158,11,0.08); color: #92400e; border: 1px solid rgba(245,158,11,0.2); border-left: 3px solid #f59e0b; }
        .lv-alert ul { margin: 4px 0 0 16px; padding: 0; }

        /* CARDS */
        .lv-card { background: #fff; border-radius: 10px; border: 1px solid rgba(14,165,160,0.15); box-shadow: 0 2px 16px rgba(6,62,60,0.07); margin-bottom: 18px; overflow: hidden; }
        .lv-card-head { padding: 13px 18px; border-bottom: 1px solid rgba(14,165,160,0.1); display: flex; align-items: center; gap: 8px; }
        .lv-card-head h4 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #0a2e2c; margin: 0; }
        .lv-card-head i  { color: #0EA5A0; font-size: 12px; }
        .lv-card-head.lv-dark { background: #0a5654; }
        .lv-card-head.lv-dark h4 { color: #fff; }
        .lv-card-head.lv-dark i  { color: rgba(255,255,255,0.7); }
        .lv-card-body { padding: 16px 18px; }

        /* BALANCE */
        .lv-bal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .lv-bal-item { padding: 12px 14px; border-radius: 8px; background: #f0fafa; border: 1px solid rgba(14,165,160,0.12); }
        .lv-bal-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #4a7a76; margin-bottom: 4px; }
        .lv-bal-value { font-size: 20px; font-weight: 700; color: #0EA5A0; line-height: 1.1; }
        .lv-bal-value.mc { color: #ef4444; }
        .lv-bal-meta  { font-size: 11px; color: #4a7a76; margin-top: 2px; }
        .lv-bal-unlimited { font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #22c55e; margin-top: 2px; }
        .lv-intern-note { margin-top: 12px; padding: 9px 13px; background: rgba(245,158,11,0.08); border-left: 3px solid #f59e0b; border-radius: 6px; font-size: 11px; color: #92400e; }

        /* FORM */
        .lv-form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
        .lv-form-group { margin-bottom: 14px; }
        .lv-form-group label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.7px; text-transform: uppercase; color: #4a7a76; margin-bottom: 5px; }
        .lv-form-group label i { margin-right: 3px; }
        .lv-req { color: #ef4444; }
        .lv-input {
            width: 100%; padding: 9px 11px; border: 1px solid rgba(14,165,160,0.2); border-radius: 7px;
            font-family: 'Poppins', sans-serif; font-size: 13px; color: #0a2e2c; background: #fff; outline: none;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .lv-input:focus { border-color: #0EA5A0; box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        .lv-input[readonly], .lv-input:disabled { background: #f5f5f5; color: #4a7a76; cursor: not-allowed; }
        .lv-input.lv-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%230EA5A0' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 11px center; padding-right: 32px; cursor: pointer;
        }
        textarea.lv-input { resize: vertical; min-height: 90px; }
        .lv-hint { font-size: 11px; color: #4a7a76; margin-top: 4px; }
        .lv-bal-display { width: 100%; padding: 9px 11px; border: 1px solid rgba(14,165,160,0.15); border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; background: #f5f5f5; color: #4a7a76; cursor: not-allowed; }
        .lv-total     { font-weight: 700; font-size: 14px; color: #0EA5A0 !important; }
        .lv-total-bad { font-weight: 700; font-size: 14px; color: #ef4444 !important; }

        /* HALF-DAY ROW */
        .lv-half-row { display: none; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
        .lv-half-row.show { display: grid; }

        /* DAILY LIMIT BOX */
        .lv-limit-box { border-radius: 8px; padding: 13px 15px; margin-bottom: 14px; font-size: 12px; border-left: 3px solid transparent; }
        .lv-lim-first   { background: rgba(34,197,94,0.08);  border-color: #22c55e; color: #166534; }
        .lv-lim-pending { background: rgba(14,165,160,0.08); border-color: #0EA5A0; color: #0a5654; }
        .lv-lim-waiting { background: rgba(245,158,11,0.08); border-color: #f59e0b; color: #92400e; }
        .lv-lim-title  { font-weight: 700; margin-bottom: 6px; font-size: 12px; }
        .lv-lim-meta   { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin: 7px 0; font-size: 11px; }
        .lv-lim-badge  { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; letter-spacing: 0.5px; color: #fff; }
        .lv-lim-first   .lv-lim-badge { background: #22c55e; }
        .lv-lim-pending .lv-lim-badge { background: #0EA5A0; }
        .lv-lim-waiting .lv-lim-badge { background: #f59e0b; }
        .lv-lim-msg   { font-size: 11px; line-height: 1.6; }
        .lv-lim-dates { font-size: 10px; margin-top: 7px; opacity: 0.75; }

        /* RULES BOX */
        .lv-rules { background: rgba(14,165,160,0.06); border: 1px solid rgba(14,165,160,0.15); border-left: 3px solid #0EA5A0; border-radius: 8px; padding: 13px 15px; margin-bottom: 14px; display: none; }
        .lv-rules-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #0a5654; margin-bottom: 8px; }
        .lv-rules-title i { color: #0EA5A0; margin-right: 5px; }
        .lv-rules ul { list-style: none; padding: 0; margin: 0; }
        .lv-rules ul li { font-size: 11px; color: #4a7a76; padding: 3px 0; display: flex; align-items: flex-start; gap: 6px; line-height: 1.5; }
        .lv-rules ul li::before { content: '›'; color: #0EA5A0; font-weight: 700; flex-shrink: 0; }

        /* ACTIONS */
        .lv-actions { display: flex; gap: 10px; padding-top: 14px; border-top: 1px solid rgba(14,165,160,0.1); margin-top: 4px; }
        .lv-btn-sub {
            background: #0EA5A0; color: #fff; border: none; padding: 10px 20px;
            border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background 0.2s;
        }
        .lv-btn-sub:hover { background: #0c9490; }
        .lv-btn-can {
            background: #f0fafa; color: #4a7a76; border: 1px solid rgba(14,165,160,0.2); padding: 10px 20px;
            border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s;
        }
        .lv-btn-can:hover { background: #e0f0f0; color: #0a2e2c; }

        @media (max-width: 768px) {
            .lv-sidebar { width: 200px; }
            .lv-form-row, .lv-half-row.show { grid-template-columns: 1fr; }
            .lv-bal-grid { grid-template-columns: 1fr; }
            .lv-content { padding: 16px; }
        }
    </style>
</head>
<body>
<div class="lv-layout">

    <!-- SIDEBAR -->
    <aside class="lv-sidebar">
        <div class="lv-sb-header">
            <div class="lv-sb-brand">O&M</div>
            <div class="lv-sb-role">{{ ucfirst(Auth::user()->role === 'superadmin' ? 'Admin' : str_replace('_', ' ', Auth::user()->role)) }} Dashboard</div>
            <div class="lv-sb-user">{{ Auth::user()->name }}</div>
        </div>
        <nav class="lv-sb-nav">
            <ul>
                <li class="{{ request()->routeIs(Auth::user()->dashboard_route) ? 'active' : '' }}">
                    <a href="{{ route(Auth::user()->dashboard_route) }}"><i class="fas fa-home"></i><span>Dashboard</span></a>
                </li>
                <li class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <a href="{{ route('profile.show') }}"><i class="fas fa-user"></i><span>My Profile</span></a>
                </li>
                @if(Auth::user()->canAccessAdmin())
                <li class="{{ request()->routeIs('admin.pending-staff') ? 'active' : '' }}">
                    <a href="{{ route('admin.pending-staff') }}"><i class="fas fa-user-clock"></i><span>Account Approval</span></a>
                </li>
                <li class="{{ request()->routeIs('admin.all-staff') ? 'active' : '' }}">
                    <a href="{{ route('admin.all-staff') }}"><i class="fas fa-users"></i><span>All Staff</span></a>
                </li>
                @endif
                <li class="{{ request()->routeIs(Auth::user()->team_staff_route) ? 'active' : '' }}">
                    <a href="{{ route(Auth::user()->team_staff_route) }}"><i class="fas fa-sitemap"></i><span>Team Staff</span></a>
                </li>
                @if(Auth::user()->canAccessAdmin())
                <li class="{{ request()->routeIs('admin.leave.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.leave.index') }}"><i class="fas fa-calendar-check"></i><span>Leave Management</span></a>
                </li>
                @endif
                <li class="{{ request()->routeIs('leave.*') && !request()->routeIs('admin.leave.*') ? 'active' : '' }}">
                    <a href="{{ route('leave.index') }}"><i class="fas fa-umbrella-beach"></i><span>My Leave</span></a>
                </li>
                <li class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                    <a href="{{ route('calendar.index') }}"><i class="fas fa-calendar-alt"></i><span>Calendar</span></a>
                </li>
                <li class="{{ request()->routeIs('birthdays.*') ? 'active' : '' }}">
                    <a href="{{ route('birthdays.index') }}"><i class="fas fa-gift"></i><span>Staff Birthday</span></a>
                </li>
                <li class="lv-logout">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </aside>

    <!-- MAIN -->
    <main class="lv-main">
        <div class="lv-topbar">
            <div class="lv-breadcrumb">
                <i class="fas fa-home"></i>
                <span class="lv-sep">›</span>
                <a href="{{ route('leave.index') }}">My Leave</a>
                <span class="lv-sep">›</span>
                <span class="lv-current">Apply for Leave</span>
            </div>
        </div>

        <div class="lv-content">

            @if(session('error'))
            <div class="lv-alert lv-alert-error"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</div>
            @endif
            @if(session('warning'))
            <div class="lv-alert lv-alert-warning" id="alertWarning"><i class="fas fa-exclamation-circle"></i> {{ session('warning') }}</div>
            @endif
            @if($errors->any())
            <div class="lv-alert lv-alert-error">
                <div><i class="fas fa-exclamation-triangle"></i></div>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <!-- BALANCE CARD -->
            <div class="lv-card">
                <div class="lv-card-head">
                    <i class="fas fa-wallet"></i>
                    <h4>Your Current Leave Balance</h4>
                </div>
                <div class="lv-card-body">
                    <div class="lv-bal-grid">
                        <div class="lv-bal-item">
                            <div class="lv-bal-label">Annual Leave (AL / EL)</div>
                            @if(in_array(Auth::user()->role, ['part_time','staff_ge']))
                                <div class="lv-bal-value">{{ $entitlement->annual_leave_used }} days used</div>
                                <div class="lv-bal-unlimited">Unlimited</div>
                            @else
                                <div class="lv-bal-value">{{ $entitlement->annual_leave_balance }} days</div>
                                <div class="lv-bal-meta">Used: {{ $entitlement->annual_leave_used }} / {{ $entitlement->annual_leave_total }}</div>
                            @endif
                        </div>
                        <div class="lv-bal-item">
                            <div class="lv-bal-label">Medical Leave (MC)</div>
                            @if(in_array(Auth::user()->role, ['part_time','staff_ge']))
                                <div class="lv-bal-value mc">{{ $entitlement->medical_leave_used }} days used</div>
                                <div class="lv-bal-unlimited">Unlimited</div>
                            @else
                                <div class="lv-bal-value mc">{{ $entitlement->medical_leave_balance }} days</div>
                                <div class="lv-bal-meta">Used: {{ $entitlement->medical_leave_used }} / {{ $entitlement->medical_leave_total }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM CARD -->
            <div class="lv-card">
                <div class="lv-card-head lv-dark">
                    <i class="fas fa-calendar-plus"></i>
                    <h4>Leave Application Details</h4>
                </div>
                <div class="lv-card-body">
                    <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Leave type + balance display -->
                        <div class="lv-form-row">
                            <div class="lv-form-group">
                                <label for="leave_type"><i class="fas fa-tag"></i> Leave Type <span class="lv-req">*</span></label>
                                <select class="lv-input lv-select" id="leave_type" name="leave_type" required>
                                    <option value="">Select Leave Type</option>
                                    @php $role = Auth::user()->role; @endphp
                                    @if(!in_array($role, ['part_time','staff_ge']))
                                    <optgroup label="Annual / Emergency Leave (Counted)">
                                        <option value="AL"          {{ old('leave_type')=='AL'          ?'selected':'' }}>AL - Annual Leave (Full Day)</option>
                                        <option value="HALF_DAY_AL" {{ old('leave_type')=='HALF_DAY_AL' ?'selected':'' }}>AL - Annual Leave (Half Day)</option>
                                        <option value="EL"          {{ old('leave_type')=='EL'          ?'selected':'' }}>EL - Emergency Leave (Full Day)</option>
                                        <option value="HALF_DAY_EL" {{ old('leave_type')=='HALF_DAY_EL' ?'selected':'' }}>EL - Emergency Leave (Half Day)</option>
                                    </optgroup>
                                    @else
                                    <optgroup label="Annual Leave (Counted)">
                                        <option value="AL"          {{ old('leave_type')=='AL'          ?'selected':'' }}>AL - Annual Leave (Full Day)</option>
                                        <option value="HALF_DAY_AL" {{ old('leave_type')=='HALF_DAY_AL' ?'selected':'' }}>AL - Annual Leave (Half Day)</option>
                                    </optgroup>
                                    @endif
                                    @if($role !== 'part_time')
                                    <optgroup label="Medical Leave (Counted)">
                                        <option value="MC" {{ old('leave_type')=='MC' ?'selected':'' }}>MC - Medical Leave</option>
                                    </optgroup>
                                    @endif
                                    @if(!in_array($role, ['part_time','staff_ge']))
                                    <optgroup label="Special Leave (Not Counted)">
                                        <option value="CL"  {{ old('leave_type')=='CL'  ?'selected':'' }}>CL - Compassionate Leave (3 days)</option>
                                        <option value="MRL" {{ old('leave_type')=='MRL' ?'selected':'' }}>MRL - Married Leave (3 days)</option>
                                        <option value="ML"  {{ old('leave_type')=='ML'  ?'selected':'' }}>ML - Maternity Leave (max 98 days)</option>
                                        <option value="PL"  {{ old('leave_type')=='PL'  ?'selected':'' }}>PL - Paternity Leave (max 7 days)</option>
                                        <option value="WFH" {{ old('leave_type')=='WFH' ?'selected':'' }}>WFH - Work From Home</option>
                                        <option value="RL"  {{ old('leave_type')=='RL'  ?'selected':'' }}>RL - Replacement Leave</option>
                                        <option value="SL"  {{ old('leave_type')=='SL'  ?'selected':'' }}>SL - Special Leave</option>
                                    </optgroup>
                                    @endif
                                </select>
                                <div class="lv-hint" id="leave_type_hint">Choose the type of leave you want to apply</div>
                            </div>
                            <div class="lv-form-group">
                                <label><i class="fas fa-info-circle"></i> Available Balance / Info</label>
                                <input type="text" class="lv-bal-display" id="available_balance" readonly value="Please select leave type">
                            </div>
                        </div>

                        <!-- Half-day period (hidden until needed) -->
                        <div class="lv-half-row" id="half_day_period_row">
                            <div class="lv-form-group">
                                <label for="half_day_period"><i class="fas fa-clock"></i> Half Day Period <span class="lv-req">*</span></label>
                                <select class="lv-input lv-select" id="half_day_period" name="half_day_period">
                                    <option value="">Select Period</option>
                                    <option value="AM" {{ old('half_day_period')=='AM' ?'selected':'' }}>AM (Morning)</option>
                                    <option value="PM" {{ old('half_day_period')=='PM' ?'selected':'' }}>PM (Afternoon)</option>
                                </select>
                                <div class="lv-hint">Select morning or afternoon</div>
                            </div>
                        </div>

                        <!-- Date range -->
                        <div class="lv-form-row">
                            <div class="lv-form-group">
                                <label for="start_date"><i class="fas fa-calendar-day"></i> Start Date <span class="lv-req">*</span></label>
                                <input type="date" class="lv-input" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            </div>
                            <div class="lv-form-group">
                                <label for="end_date"><i class="fas fa-calendar-day"></i> End Date <span class="lv-req">*</span></label>
                                <input type="date" class="lv-input" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            </div>
                        </div>

                        <!-- Total days + attachment -->
                        <div class="lv-form-row">
                            <div class="lv-form-group">
                                <label><i class="fas fa-calculator"></i> Total Days</label>
                                <input type="text" class="lv-input lv-total" id="total_days" readonly value="0 day(s)">
                                <div class="lv-hint">Auto-calculated based on dates selected</div>
                            </div>
                            <div class="lv-form-group">
                                <label for="attachment"><i class="fas fa-paperclip"></i> Attachment <span id="attachment_required" style="display:none;color:#ef4444;">*</span></label>
                                <input type="file" class="lv-input" id="attachment" name="attachment" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="lv-hint" id="attachment_note">Upload certificate (PDF, JPG, PNG – Max 2MB). <strong>Submit hard copy as well if you have one.</strong></div>
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="lv-form-group">
                            <label for="reason"><i class="fas fa-comment"></i> Reason <span class="lv-req">*</span></label>
                            <textarea class="lv-input" id="reason" name="reason" rows="4" required placeholder="Please provide the reason for your leave application...">{{ old('reason') }}</textarea>
                        </div>

                        <!--  Daily limit warning injected by JS before the rules box -->

                        <!-- Leave rules info -->
                        <div class="lv-rules" id="leave_rules_info">
                            <div class="lv-rules-title"><i class="fas fa-info-circle"></i><span id="leave_rules_title">Important Rules</span></div>
                            <ul id="leave_rules_list"></ul>
                        </div>

                        <div class="lv-actions">
                            <button type="submit" class="lv-btn-sub"><i class="fas fa-paper-plane"></i> Submit Application</button>
                            <a href="{{ route('leave.index') }}" class="lv-btn-can"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const leaveTypeSelect      = document.getElementById('leave_type');
    const startDateInput       = document.getElementById('start_date');
    const endDateInput         = document.getElementById('end_date');
    const totalDaysInput       = document.getElementById('total_days');
    const availableBalanceInput= document.getElementById('available_balance');
    const attachmentInput      = document.getElementById('attachment');
    const attachmentRequired   = document.getElementById('attachment_required');
    const attachmentNote       = document.getElementById('attachment_note');
    const leaveRulesInfo       = document.getElementById('leave_rules_info');
    const leaveRulesTitle      = document.getElementById('leave_rules_title');
    const leaveRulesList       = document.getElementById('leave_rules_list');
    const leaveTypeHint        = document.getElementById('leave_type_hint');
    const halfDayPeriodRow     = document.getElementById('half_day_period_row');
    const halfDayPeriodSelect  = document.getElementById('half_day_period');

    const alBalance   = {{ $entitlement->annual_leave_balance }};
    const mcBalance   = {{ $entitlement->medical_leave_balance }};
    const userRole    = '{{ Auth::user()->role }}';
    const isUnlimited = ['part_time','staff_ge'].includes(userRole);
    const today       = new Date().toISOString().split('T')[0];

    //  LOCKED DATES — add date strings here to block them e.g. '2026-03-01'
    const lockedDates = [];

    function isDateLocked(d) { return lockedDates.includes(d); }

    function setupDateRestrictions() {
        startDateInput.addEventListener('input', function() {
            if (isDateLocked(this.value)) {
                alert('⚠️ This date is locked: ' + formatDateDisplay(this.value));
                this.value = ''; endDateInput.value = ''; totalDaysInput.value = '0 day(s)';
            }
        });
        endDateInput.addEventListener('input', function() {
            if (isDateLocked(this.value)) {
                alert('⚠️ This date is locked: ' + formatDateDisplay(this.value));
                this.value = ''; totalDaysInput.value = '0 day(s)';
            }
        });
    }

    function checkLockedDatesInRange(s, e) {
        if (!s || !e) return [];
        const start = new Date(s), end = new Date(e), locked = [];
        for (let d = new Date(start); d <= end; d.setDate(d.getDate()+1)) {
            const ds = d.toISOString().split('T')[0];
            if (isDateLocked(ds)) locked.push(formatDateDisplay(ds));
        }
        return locked;
    }

    function formatDateDisplay(ds) {
        const d = new Date(ds);
        return String(d.getDate()).padStart(2,'0') + '/' + String(d.getMonth()+1).padStart(2,'0') + '/' + d.getFullYear();
    }

    setupDateRestrictions();

    const leaveTypeConfig = {
        'AL':          { name:'Annual Leave',             balance:alBalance, requiresAttachment:false, fixedDays:null, maxDays:null, autoCalculate:false, allowBackdate:false, backdateDays:0,  rules:['Requires Admin approval','Must be applied at least 2 days in advance','Cannot be applied for today or past dates','Balance will be deducted upon approval',`You currently have ${alBalance} days available`] },
        'HALF_DAY_AL': { name:'Half Day Annual Leave',    balance:alBalance, requiresAttachment:false, fixedDays:0.5,  maxDays:null, autoCalculate:false, allowBackdate:false, backdateDays:0,  isHalfDay:true, rules:['Requires Admin approval','Must be applied at least 2 days in advance','Cannot be applied for today or past dates','Counted as 0.5 days','Select AM (Morning) or PM (Afternoon)',`You currently have ${alBalance} days available`] },
        'EL':          { name:'Emergency Leave',          balance:alBalance, requiresAttachment:false, fixedDays:null, maxDays:null, autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['Can be applied same day (emergency)','Can be backdated up to 118 days',`You currently have ${alBalance} days available`] },
        'HALF_DAY_EL': { name:'Half Day Emergency Leave', balance:alBalance, requiresAttachment:false, fixedDays:0.5,  maxDays:null, autoCalculate:false, allowBackdate:true,  backdateDays:118, isHalfDay:true, rules:['Can be applied same day (emergency)','Can be backdated up to 118 days','Counted as 0.5 days','Select AM (Morning) or PM (Afternoon)',`You currently have ${alBalance} days available`] },
        'MC':          { name:'Medical Leave',            balance:mcBalance, requiresAttachment:true,  fixedDays:null, maxDays:null, autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['Medical certificate (MC) is MANDATORY','Can be backdated up to 118 days',`You currently have ${mcBalance} days available`,'Please submit hard copy of MC as well'] },
        'CL':          { name:'Compassionate Leave',      balance:null,      requiresAttachment:false, fixedDays:3,    maxDays:null, autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Must be exactly 3 consecutive calendar days (includes weekends)','End date will be auto-calculated','Can be backdated up to 118 days','Not deducted from leave balance','For family emergencies or bereavement'] },
        'MRL':         { name:'Married Leave',            balance:null,      requiresAttachment:false, fixedDays:3,    maxDays:null, autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Must be exactly 3 consecutive calendar days (includes weekends)','End date will be auto-calculated','Can be backdated up to 118 days','Not deducted from leave balance','For marriage ceremony'] },
        'WFH':         { name:'Work From Home',           balance:null,      requiresAttachment:false, fixedDays:null, maxDays:null, autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['Can be applied same day','Can be backdated up to 118 days','No limit on days','Not deducted from leave balance'] },
        'ML':          { name:'Maternity Leave',          balance:null,      requiresAttachment:true,  fixedDays:null, maxDays:98,   autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Maximum 98 calendar days (includes weekends)','End date will be auto-calculated','Can be backdated up to 118 days','Supporting documents required','Not deducted from leave balance','Exempt from daily leave limit','Please submit hard copy of documents as well'] },
        'PL':          { name:'Paternity Leave',          balance:null,      requiresAttachment:true,  fixedDays:null, maxDays:7,    autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Maximum 7 calendar days (includes weekends)','End date will be auto-calculated','Can be backdated up to 118 days','Supporting documents required','Not deducted from leave balance','Exempt from daily leave limit','Please submit hard copy of documents as well'] },
        'RL':          { name:'Replacement Leave',        balance:null,      requiresAttachment:false, fixedDays:null, maxDays:null, autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['For compensating work done on rest days/public holidays','Can be backdated up to 118 days','Not deducted from leave balance'] },
        'SL':          { name:'Special Leave',            balance:null,      requiresAttachment:false, fixedDays:null, maxDays:null, autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['For special circumstances not covered by other leave types','Can be backdated up to 118 days','Not deducted from leave balance','Admin approval with remark required','Examples: Quarantine, special personal matters, etc.'] },
    };

    const singleDayTypes = ['AL','EL','MC','WFH','RL','SL'];

    leaveTypeSelect.addEventListener('change', function() {
        const sel = this.value;
        if (!sel) {
            availableBalanceInput.value = 'Please select leave type';
            availableBalanceInput.style.color = '#4a7a76';
            attachmentInput.required = false; attachmentRequired.style.display = 'none';
            attachmentNote.innerHTML = 'Upload certificate (PDF, JPG, PNG – Max 2MB). <strong>Submit hard copy as well if you have one.</strong>';
            leaveRulesInfo.style.display = 'none';
            leaveTypeHint.textContent = 'Choose the type of leave you want to apply';
            halfDayPeriodRow.classList.remove('show'); halfDayPeriodSelect.required = false;
            startDateInput.readOnly = false; endDateInput.readOnly = false;
            startDateInput.min = today; return;
        }

        const cfg = leaveTypeConfig[sel];

        if (cfg.isHalfDay) { halfDayPeriodRow.classList.add('show'); halfDayPeriodSelect.required = true; endDateInput.readOnly = true; }
        else { halfDayPeriodRow.classList.remove('show'); halfDayPeriodSelect.required = false; halfDayPeriodSelect.value = ''; }

        if (cfg.balance !== null) {
            availableBalanceInput.value = isUnlimited ? 'Unlimited' : cfg.balance + ' days available';
            availableBalanceInput.style.color = isUnlimited ? '#22c55e' : (cfg.balance > 0 ? '#0EA5A0' : '#ef4444');
        } else if (cfg.fixedDays && cfg.fixedDays !== 0.5) {
            availableBalanceInput.value = 'Fixed ' + cfg.fixedDays + ' days'; availableBalanceInput.style.color = '#f59e0b';
        } else if (cfg.fixedDays === 0.5) {
            availableBalanceInput.value = 'Half Day (0.5 days)'; availableBalanceInput.style.color = '#3b82f6';
        } else if (cfg.maxDays) {
            availableBalanceInput.value = 'Maximum ' + cfg.maxDays + ' days'; availableBalanceInput.style.color = '#3b82f6';
        } else {
            availableBalanceInput.value = 'No limit (not counted)'; availableBalanceInput.style.color = '#22c55e';
        }

        if (cfg.requiresAttachment) {
            attachmentInput.required = true; attachmentRequired.style.display = 'inline';
            attachmentNote.innerHTML = '<strong style="color:#ef4444;">MANDATORY: Medical certificate required!</strong> Please submit hard copy as well.';
        } else {
            attachmentInput.required = false; attachmentRequired.style.display = 'none';
            attachmentNote.innerHTML = 'Upload certificate (PDF, JPG, PNG – Max 2MB). <strong>Submit hard copy as well if you have one.</strong>';
        }

        if (cfg.allowBackdate) {
            const minDate = new Date(); minDate.setDate(minDate.getDate() - cfg.backdateDays);
            startDateInput.min = minDate.toISOString().split('T')[0];
        } else {
            const minAdvance = new Date(); minAdvance.setDate(minAdvance.getDate() + 2);
            startDateInput.min = minAdvance.toISOString().split('T')[0];
        }

        if (cfg.autoCalculate) { endDateInput.readOnly = true; startDateInput.readOnly = false; }
        else if (singleDayTypes.includes(sel)) {
            endDateInput.readOnly = true; startDateInput.readOnly = false;
            if (startDateInput.value) { endDateInput.value = startDateInput.value; calculateTotalDays(); }
        } else { endDateInput.readOnly = cfg.isHalfDay; startDateInput.readOnly = false; }

        leaveRulesTitle.textContent = cfg.name + ' – Important Rules';
        leaveRulesList.innerHTML = cfg.rules.map(r => '<li>' + r + '</li>').join('');
        leaveRulesInfo.style.display = 'block';
        leaveTypeHint.textContent = cfg.name;

        if (cfg.autoCalculate || cfg.isHalfDay) { startDateInput.value = ''; endDateInput.value = ''; totalDaysInput.value = '0 day(s)'; }

        checkDailyLimit();
    });

    startDateInput.addEventListener('change', function() {
        const sel = leaveTypeSelect.value; if (!sel) return;
        const cfg = leaveTypeConfig[sel]; const sd = this.value;

        if (cfg.autoCalculate && sd) {
            const start = new Date(sd); let end;
            if (sel==='CL'||sel==='MRL') { end = new Date(start); end.setDate(end.getDate()+2); }
            else if (sel==='ML') { end = new Date(start); end.setDate(end.getDate()+97); }
            else if (sel==='PL') { end = new Date(start); end.setDate(end.getDate()+6); }
            if (end) { endDateInput.value = end.toISOString().split('T')[0]; calculateTotalDays(); }
        } else if (cfg.isHalfDay && sd) {
            endDateInput.value = sd;
            totalDaysInput.value = '0.5 day (Half Day)';
            totalDaysInput.style.color = '#0EA5A0';
        } else if (singleDayTypes.includes(sel) && sd) {
            endDateInput.value = sd; calculateTotalDays();
        } else { endDateInput.min = sd; calculateTotalDays(); }

        checkDailyLimit();
    });

    endDateInput.addEventListener('change', function() { calculateTotalDays(); checkDailyLimit(); });
    halfDayPeriodSelect.addEventListener('change', calculateTotalDays);

    function calculateTotalDays() {
        const s = startDateInput.value, e = endDateInput.value, sel = leaveTypeSelect.value;
        if (!s || !e) { totalDaysInput.value = '0 day(s)'; totalDaysInput.style.color = '#0EA5A0'; return; }
        const cfg = leaveTypeConfig[sel];
        if (cfg && cfg.isHalfDay) { totalDaysInput.value = '0.5 day (Half Day)'; totalDaysInput.style.color = '#0EA5A0'; return; }
        const start = new Date(s), end = new Date(e);
        if (end < start) { totalDaysInput.value = 'Invalid dates'; totalDaysInput.style.color = '#ef4444'; return; }
        const locked = checkLockedDatesInRange(s, e);
        if (locked.length) { totalDaysInput.value = 'Contains locked date(s)'; totalDaysInput.style.color = '#ef4444'; alert('⚠️ Locked dates in range: ' + locked.join(', ')); return; }
        const days = Math.ceil(Math.abs(end-start)/(1000*60*60*24)) + 1;
        totalDaysInput.value = days + ' day(s)'; totalDaysInput.style.color = '#0EA5A0';
        if (cfg) {
            if (cfg.fixedDays && cfg.fixedDays !== 0.5 && days !== cfg.fixedDays) { totalDaysInput.style.color = '#ef4444'; alert('Warning: ' + cfg.name + ' must be exactly ' + cfg.fixedDays + ' days.'); }
            if (cfg.maxDays && days > cfg.maxDays) { totalDaysInput.style.color = '#ef4444'; alert('Warning: ' + cfg.name + ' cannot exceed ' + cfg.maxDays + ' days.'); }
            if (!isUnlimited && cfg.balance !== null && days > cfg.balance) { totalDaysInput.style.color = '#ef4444'; alert('Warning: You only have ' + cfg.balance + ' days available. Your application may be rejected.'); }
        }
    }

    async function checkDailyLimit() {
        const s = startDateInput.value, e = endDateInput.value, lt = leaveTypeSelect.value;
        const existing = document.getElementById('daily_limit_warning');
        if (existing) existing.remove();
        if (!s || !e || !lt || ['ML','PL'].includes(lt)) return;
        try {
            const res = await fetch('/leave/check-daily-limit', {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ start_date:s, end_date:e, leave_type:lt })
            });
            const data = await res.json();
            if (data.hasLimit && !data.isExempt) showDailyLimitWarning(data);
        } catch(err) { console.error(err); }
    }

    function showDailyLimitWarning(data) {
        let cls, statusText, msg;
        const parts = [];
        if (data.approvedCount > 0) parts.push(data.approvedCount + ' staff approved');
        if (data.pendingCount  > 0) parts.push(data.pendingCount  + ' staff pending');
        if (data.waitingCount  > 0) parts.push(data.waitingCount  + ' staff waiting');

        if (data.willBeWaitingList) {
            cls = 'lv-lim-waiting'; statusText = 'WAITING LIST';
            msg = `You'll be the <strong>${data.position}</strong> person to apply. Your application will be on <strong>WAITING LIST</strong>. Please meet Admin (Ramyan) ASAP after submitting.`;
        } else if (data.totalCount > 0) {
            cls = 'lv-lim-pending'; statusText = 'PENDING';
            msg = `You'll be the <strong>${data.position}</strong> person to apply. Status will be <strong>PENDING</strong>. Admin will review your application.`;
        } else {
            cls = 'lv-lim-first'; statusText = 'PENDING';
            msg = `You're the first applicant for these dates! Status will be <strong>PENDING</strong>.`;
        }

        const title = parts.length ? parts.join(' + ') + ' for these dates' : 'No other applications for these dates';

        const html = `<div id="daily_limit_warning" class="lv-limit-box ${cls}">
            <div class="lv-lim-title">${title}</div>
            <div class="lv-lim-meta">
                <span>Your Position: <strong>${data.position}</strong> applicant</span>
                <span class="lv-lim-badge">Expected: ${statusText}</span>
            </div>
            <div class="lv-lim-msg">${msg}</div>
            ${data.affectedDates?.length ? `<div class="lv-lim-dates"><strong>Affected dates:</strong> ${data.affectedDates.join(', ')}</div>` : ''}
        </div>`;

        leaveRulesInfo.insertAdjacentHTML('beforebegin', html);
    }

    // Auto-dismiss warning session alert
    const aw = document.getElementById('alertWarning');
    if (aw) setTimeout(() => { aw.style.transition='opacity 1s'; aw.style.opacity='0'; setTimeout(()=>aw.remove(), 1000); }, 10000);
});
</script>
</body>
</html>
