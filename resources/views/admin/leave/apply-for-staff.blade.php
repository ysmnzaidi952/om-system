{{-- C:\laragon\www\om_system\resources\views\admin\leave\apply-for-staff.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Apply Leave for Staff | O&M HRCare</title>
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
            --shadow-sm:   0 2px 16px rgba(6,62,60,0.07);
            --red:    #ef4444;
            --amber:  #f59e0b;
            --green:  #22c55e;
            --blue:   #3b82f6;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--off-white); color: var(--text-main); font-size: 14px; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .dashboard-layout { display: flex; min-height: 100vh; }
        .dashboard-main   { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* TOPBAR */
        .topbar {
            background: #fff; border-bottom: 1px solid var(--border);
            padding: 0 28px; height: 60px; display: flex; align-items: center;
            position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04);
        }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb a { color: var(--text-muted); transition: color 0.2s; }
        .topbar-breadcrumb a:hover { color: var(--teal-bright); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 600; }
        .topbar-breadcrumb .sep { opacity: 0.4; }

        /* CONTENT */
        .page-content { padding: 24px 28px; flex: 1; max-width: 960px; }

        /* ALERTS */
        .alert { display: flex; align-items: flex-start; gap: 9px; padding: 11px 14px; border-radius: 8px; margin-bottom: 14px; font-size: 13px; }
        .alert-success { background: rgba(34,197,94,0.08);  color: #166534; border: 1px solid rgba(34,197,94,0.2);  border-left: 3px solid var(--green); }
        .alert-error   { background: rgba(239,68,68,0.08);  color: #dc2626; border: 1px solid rgba(239,68,68,0.2);  border-left: 3px solid var(--red); }
        .alert-warning { background: rgba(245,158,11,0.08); color: #92400e; border: 1px solid rgba(245,158,11,0.2); border-left: 3px solid var(--amber); }
        .alert ul { margin: 4px 0 0 16px; padding: 0; }

        /* CARDS */
        .lv-card { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: 18px; overflow: hidden; }
        .lv-card-head { padding: 13px 18px; border-bottom: 1px solid rgba(14,165,160,0.1); display: flex; align-items: center; gap: 8px; }
        .lv-card-head h4 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-main); margin: 0; }
        .lv-card-head i  { color: var(--teal-bright); font-size: 12px; }
        .lv-card-head.lv-dark { background: var(--teal-base); }
        .lv-card-head.lv-dark h4 { color: #fff; }
        .lv-card-head.lv-dark i  { color: rgba(255,255,255,0.7); }
        .lv-card-body { padding: 16px 18px; }

        /* STAFF INFO BOX */
        .staff-info-box {
            display: none;
            padding: 14px 16px;
            border-radius: 8px;
            background: rgba(14,165,160,0.06);
            border: 1px solid rgba(14,165,160,0.15);
            margin-top: 10px;
            gap: 14px;
            align-items: center;
        }
        .staff-info-box.show { display: flex; }
        .staff-info-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--teal-base), var(--teal-bright));
            color: #fff; font-size: 16px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .staff-info-details { flex: 1; }
        .staff-info-name { font-size: 13px; font-weight: 700; color: var(--text-main); }
        .staff-info-meta { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
        .staff-info-bal  { display: flex; gap: 10px; margin-top: 8px; flex-wrap: wrap; }
        .bal-chip {
            padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700;
            background: rgba(14,165,160,0.1); color: var(--teal-base);
        }
        .bal-chip.mc { background: rgba(239,68,68,0.08); color: #991b1b; }
        .bal-chip.unlimited { background: rgba(34,197,94,0.1); color: #166534; }

        /* FORM */
        .lv-form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
        .lv-form-group { margin-bottom: 14px; }
        .lv-form-group label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.7px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; }
        .lv-form-group label i { margin-right: 3px; }
        .lv-req { color: var(--red); }
        .lv-input {
            width: 100%; padding: 9px 11px; border: 1px solid rgba(14,165,160,0.2); border-radius: 7px;
            font-family: 'Poppins', sans-serif; font-size: 13px; color: var(--text-main); background: #fff; outline: none;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .lv-input:focus { border-color: var(--teal-bright); box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        .lv-input[readonly], .lv-input:disabled { background: #f5f5f5; color: var(--text-muted); cursor: not-allowed; }
        .lv-input.lv-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%230EA5A0' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 11px center; padding-right: 32px; cursor: pointer;
        }
        textarea.lv-input { resize: vertical; min-height: 90px; }
        .lv-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }
        .lv-bal-display { width: 100%; padding: 9px 11px; border: 1px solid rgba(14,165,160,0.15); border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600; background: #f5f5f5; color: var(--text-muted); cursor: not-allowed; }

        /* HALF DAY ROW */
        .lv-half-row { display: none; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
        .lv-half-row.show { display: grid; }

        /* APPROVAL NOTE ROW */
        .lv-sl-row { display: none; margin-bottom: 14px; }
        .lv-sl-row.show { display: block; }

        /* DAILY LIMIT BOX */
        .lv-limit-box { border-radius: 8px; padding: 13px 15px; margin-bottom: 14px; font-size: 12px; border-left: 3px solid transparent; }
        .lv-lim-first   { background: rgba(34,197,94,0.08);  border-color: var(--green); color: #166534; }
        .lv-lim-pending { background: rgba(14,165,160,0.08); border-color: var(--teal-bright); color: var(--teal-base); }
        .lv-lim-waiting { background: rgba(245,158,11,0.08); border-color: var(--amber); color: #92400e; }
        .lv-lim-title  { font-weight: 700; margin-bottom: 6px; font-size: 12px; }
        .lv-lim-meta   { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin: 7px 0; font-size: 11px; }
        .lv-lim-badge  { font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; letter-spacing: 0.5px; color: #fff; }
        .lv-lim-first   .lv-lim-badge { background: var(--green); }
        .lv-lim-pending .lv-lim-badge { background: var(--teal-bright); }
        .lv-lim-waiting .lv-lim-badge { background: var(--amber); }
        .lv-lim-msg   { font-size: 11px; line-height: 1.6; }
        .lv-lim-dates { font-size: 10px; margin-top: 7px; opacity: 0.75; }

        /* RULES BOX */
        .lv-rules { background: rgba(14,165,160,0.06); border: 1px solid rgba(14,165,160,0.15); border-left: 3px solid var(--teal-bright); border-radius: 8px; padding: 13px 15px; margin-bottom: 14px; display: none; }
        .lv-rules-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--teal-base); margin-bottom: 8px; }
        .lv-rules-title i { color: var(--teal-bright); margin-right: 5px; }
        .lv-rules ul { list-style: none; padding: 0; margin: 0; }
        .lv-rules ul li { font-size: 11px; color: var(--text-muted); padding: 3px 0; display: flex; align-items: flex-start; gap: 6px; line-height: 1.5; }
        .lv-rules ul li::before { content: '›'; color: var(--teal-bright); font-weight: 700; flex-shrink: 0; }

        /* ADMIN NOTE BOX */
        .admin-note-box {
            background: rgba(245,158,11,0.07);
            border: 1px solid rgba(245,158,11,0.2);
            border-left: 3px solid var(--amber);
            border-radius: 8px;
            padding: 11px 14px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #92400e;
        }
        .admin-note-box strong { font-weight: 700; }

        /* ACTIONS */
        .lv-actions { display: flex; gap: 10px; padding-top: 14px; border-top: 1px solid rgba(14,165,160,0.1); margin-top: 4px; }
        .lv-btn-sub {
            background: var(--teal-bright); color: #fff; border: none; padding: 10px 20px;
            border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background 0.2s;
        }
        .lv-btn-sub:hover { background: var(--teal-base); }
        .lv-btn-can {
            background: var(--off-white); color: var(--text-muted); border: 1px solid rgba(14,165,160,0.2); padding: 10px 20px;
            border-radius: 7px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s;
        }
        .lv-btn-can:hover { background: #e0f0f0; color: var(--text-main); }

        @media (max-width: 768px) {
            .lv-form-row, .lv-half-row.show { grid-template-columns: 1fr; }
            .page-content { padding: 16px; }
        }
    </style>
</head>
<body>
<div class="dashboard-layout">

    @include('components.sidebar2')

    <main class="dashboard-main">
        <div class="topbar">
            <div class="topbar-breadcrumb">
                <i class="fas fa-home"></i>
                <span class="sep">›</span>
                <a href="{{ route('admin.leave.index') }}">Leave Management</a>
                <span class="sep">›</span>
                <span class="current">Apply for Staff</span>
            </div>
        </div>

        <div class="page-content">

            @if(session('success'))
            <div class="alert alert-success" id="alertSuccess"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-error" id="alertError"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
            @endif
            @if(session('warning'))
            <div class="alert alert-warning" id="alertWarning"><i class="fas fa-exclamation-circle"></i> {{ session('warning') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error">
                <div><i class="fas fa-exclamation-triangle"></i></div>
                <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
            @endif

            <!-- ADMIN NOTE -->
            <div class="admin-note-box">
                <strong><i class="fas fa-shield-alt"></i> Admin Mode:</strong>
                You are submitting a leave application on behalf of a staff member.
                The application will be created with <strong>Pending</strong> status and still requires your approval via the Pending Approvals page.
            </div>

            <!-- FORM CARD -->
            <div class="lv-card">
                <div class="lv-card-head lv-dark">
                    <i class="fas fa-user-plus"></i>
                    <h4>Apply Leave on Behalf of Staff</h4>
                </div>
                <div class="lv-card-body">
                    <form action="{{ route('admin.leave.store-for-staff') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- STAFF SELECTOR -->
                        <div class="lv-form-group">
                            <label for="user_id"><i class="fas fa-user"></i> Select Staff Member <span class="lv-req">*</span></label>
                            <select class="lv-input lv-select" id="user_id" name="user_id" required>
                                <option value="">-- Select Staff --</option>
                                @foreach($staff as $member)
                                <option value="{{ $member->id }}"
                                    data-role="{{ $member->role }}"
                                    data-position="{{ $member->position }}"
                                    data-al="{{ $member->currentYearEntitlement() ? $member->currentYearEntitlement()->annual_leave_balance : 0 }}"
                                    data-mc="{{ $member->currentYearEntitlement() ? $member->currentYearEntitlement()->medical_leave_balance : 0 }}"
                                    data-alused="{{ $member->currentYearEntitlement() ? $member->currentYearEntitlement()->annual_leave_used : 0 }}"
                                    data-mcused="{{ $member->currentYearEntitlement() ? $member->currentYearEntitlement()->medical_leave_used : 0 }}"
                                    data-altotal="{{ $member->currentYearEntitlement() ? $member->currentYearEntitlement()->annual_leave_total : 0 }}"
                                    data-mctotal="{{ $member->currentYearEntitlement() ? $member->currentYearEntitlement()->medical_leave_total : 0 }}"
                                    {{ old('user_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} — {{ ucfirst(str_replace('_',' ',$member->role)) }}
                                    @if($member->position) ({{ $member->position }}) @endif
                                </option>
                                @endforeach
                            </select>
                            <div class="lv-hint">Select the staff member you want to apply leave for</div>

                            <!-- Staff info display -->
                            <div class="staff-info-box" id="staffInfoBox">
                                <div class="staff-info-avatar" id="staffAvatar">?</div>
                                <div class="staff-info-details">
                                    <div class="staff-info-name" id="staffName">-</div>
                                    <div class="staff-info-meta" id="staffMeta">-</div>
                                    <div class="staff-info-bal" id="staffBal"></div>
                                </div>
                            </div>
                        </div>

                        <!-- LEAVE TYPE + BALANCE -->
                        <div class="lv-form-row">
                            <div class="lv-form-group">
                                <label for="leave_type"><i class="fas fa-tag"></i> Leave Type <span class="lv-req">*</span></label>
                                <select class="lv-input lv-select" id="leave_type" name="leave_type" required>
                                    <option value="">Select Leave Type</option>
                                </select>
                                <div class="lv-hint" id="leave_type_hint">Select a staff member first</div>
                            </div>
                            <div class="lv-form-group">
                                <label><i class="fas fa-info-circle"></i> Available Balance / Info</label>
                                <input type="text" class="lv-bal-display" id="available_balance" readonly value="Select staff & leave type">
                            </div>
                        </div>

                        <!-- HALF DAY PERIOD -->
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

                        <!-- DATE RANGE -->
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

                        <!-- TOTAL DAYS + ATTACHMENT -->
                        <div class="lv-form-row">
                            <div class="lv-form-group">
                                <label><i class="fas fa-calculator"></i> Total Days</label>
                                <input type="text" class="lv-input" id="total_days" readonly value="0 day(s)" style="font-weight:700; color:var(--teal-bright);">
                                <div class="lv-hint">Auto-calculated based on dates selected</div>
                            </div>
                            <div class="lv-form-group">
                                <label for="attachment"><i class="fas fa-paperclip"></i> Attachment <span id="attachment_required" style="display:none;color:var(--red);">*</span></label>
                                <input type="file" class="lv-input" id="attachment" name="attachment" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="lv-hint" id="attachment_note">Upload certificate (PDF, JPG, PNG – Max 2MB).</div>
                            </div>
                        </div>

                        <!-- REASON -->
                        <div class="lv-form-group">
                            <label for="reason"><i class="fas fa-comment"></i> Reason <span class="lv-req">*</span></label>
                            <textarea class="lv-input" id="reason" name="reason" rows="3" required placeholder="Provide the reason for this leave application...">{{ old('reason') }}</textarea>
                        </div>

                        <!-- SL APPROVAL NOTE (shown only for Special Leave) -->
                        <div class="lv-sl-row" id="sl_note_row">
                            <div class="lv-form-group">
                                <label for="approval_note"><i class="fas fa-pen"></i> Admin Remark for Special Leave <span class="lv-req">*</span></label>
                                <textarea class="lv-input" id="approval_note" name="approval_note" rows="2" placeholder="Mandatory: State the reason/approval for this Special Leave...">{{ old('approval_note') }}</textarea>
                                <div class="lv-hint" style="color:#92400e;"><i class="fas fa-exclamation-circle"></i> Required for Special Leave (SL)</div>
                            </div>
                        </div>

                        <!-- Daily limit warning injected by JS -->

                        <!-- Leave rules -->
                        <div class="lv-rules" id="leave_rules_info">
                            <div class="lv-rules-title"><i class="fas fa-info-circle"></i><span id="leave_rules_title">Important Rules</span></div>
                            <ul id="leave_rules_list"></ul>
                        </div>

                        <div class="lv-actions">
                            <button type="submit" class="lv-btn-sub"><i class="fas fa-paper-plane"></i> Submit Application</button>
                            <a href="{{ route('admin.leave.index') }}" class="lv-btn-can"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const userSelect        = document.getElementById('user_id');
    const leaveTypeSelect   = document.getElementById('leave_type');
    const startDateInput    = document.getElementById('start_date');
    const endDateInput      = document.getElementById('end_date');
    const totalDaysInput    = document.getElementById('total_days');
    const availBalInput     = document.getElementById('available_balance');
    const attachInput       = document.getElementById('attachment');
    const attachRequired    = document.getElementById('attachment_required');
    const attachNote        = document.getElementById('attachment_note');
    const halfDayRow        = document.getElementById('half_day_period_row');
    const halfDaySelect     = document.getElementById('half_day_period');
    const slNoteRow         = document.getElementById('sl_note_row');
    const slNoteInput       = document.getElementById('approval_note');
    const leaveRulesInfo    = document.getElementById('leave_rules_info');
    const leaveRulesTitle   = document.getElementById('leave_rules_title');
    const leaveRulesList    = document.getElementById('leave_rules_list');
    const leaveTypeHint     = document.getElementById('leave_type_hint');
    const staffInfoBox      = document.getElementById('staffInfoBox');
    const staffAvatar       = document.getElementById('staffAvatar');
    const staffName         = document.getElementById('staffName');
    const staffMeta         = document.getElementById('staffMeta');
    const staffBal          = document.getElementById('staffBal');

    const today = new Date().toISOString().split('T')[0];

    // ─── Leave type options per role ───────────────────────────────
    const leaveTypesByRole = {
        staff: [
            { value:'AL',          label:'AL - Annual Leave (Full Day)' },
            { value:'HALF_DAY_AL', label:'AL - Annual Leave (Half Day)' },
            { value:'EL',          label:'EL - Emergency Leave (Full Day)' },
            { value:'HALF_DAY_EL', label:'EL - Emergency Leave (Half Day)' },
            { value:'MC',          label:'MC - Medical Leave' },
            { value:'CL',          label:'CL - Compassionate Leave (3 days)' },
            { value:'MRL',         label:'MRL - Married Leave (3 days)' },
            { value:'ML',          label:'ML - Maternity Leave (max 98 days)' },
            { value:'PL',          label:'PL - Paternity Leave (max 7 days)' },
            { value:'WFH',         label:'WFH - Work From Home' },
            { value:'RL',          label:'RL - Replacement Leave' },
            { value:'SL',          label:'SL - Special Leave' },
        ],
        admin: [
            { value:'AL',          label:'AL - Annual Leave (Full Day)' },
            { value:'HALF_DAY_AL', label:'AL - Annual Leave (Half Day)' },
            { value:'EL',          label:'EL - Emergency Leave (Full Day)' },
            { value:'HALF_DAY_EL', label:'EL - Emergency Leave (Half Day)' },
            { value:'MC',          label:'MC - Medical Leave' },
            { value:'CL',          label:'CL - Compassionate Leave (3 days)' },
            { value:'MRL',         label:'MRL - Married Leave (3 days)' },
            { value:'ML',          label:'ML - Maternity Leave (max 98 days)' },
            { value:'PL',          label:'PL - Paternity Leave (max 7 days)' },
            { value:'WFH',         label:'WFH - Work From Home' },
            { value:'RL',          label:'RL - Replacement Leave' },
            { value:'SL',          label:'SL - Special Leave' },
        ],
        superadmin: [
            { value:'AL',          label:'AL - Annual Leave (Full Day)' },
            { value:'HALF_DAY_AL', label:'AL - Annual Leave (Half Day)' },
            { value:'EL',          label:'EL - Emergency Leave (Full Day)' },
            { value:'HALF_DAY_EL', label:'EL - Emergency Leave (Half Day)' },
            { value:'MC',          label:'MC - Medical Leave' },
            { value:'CL',          label:'CL - Compassionate Leave (3 days)' },
            { value:'MRL',         label:'MRL - Married Leave (3 days)' },
            { value:'ML',          label:'ML - Maternity Leave (max 98 days)' },
            { value:'PL',          label:'PL - Paternity Leave (max 7 days)' },
            { value:'WFH',         label:'WFH - Work From Home' },
            { value:'RL',          label:'RL - Replacement Leave' },
            { value:'SL',          label:'SL - Special Leave' },
        ],
        intern: [
            { value:'AL',          label:'AL - Annual Leave (Full Day)' },
            { value:'HALF_DAY_AL', label:'AL - Annual Leave (Half Day)' },
            { value:'EL',          label:'EL - Emergency Leave (Full Day)' },
            { value:'HALF_DAY_EL', label:'EL - Emergency Leave (Half Day)' },
            { value:'MC',          label:'MC - Medical Leave' },
            { value:'SL',          label:'SL - Special Leave' },
        ],
        part_time: [
            { value:'AL',          label:'AL - Annual Leave (Full Day)' },
            { value:'HALF_DAY_AL', label:'AL - Annual Leave (Half Day)' },
        ],
        staff_ge: [
            { value:'AL',          label:'AL - Annual Leave (Full Day)' },
            { value:'HALF_DAY_AL', label:'AL - Annual Leave (Half Day)' },
            { value:'MC',          label:'MC - Medical Leave' },
        ],
    };

    // ─── Leave type config ──────────────────────────────────────────
    function getLeaveConfig(leaveType, alBal, mcBal, isUnlimited) {
        const configs = {
            'AL':          { name:'Annual Leave',             balance:alBal,  requiresAttachment:false, fixedDays:null, maxDays:null,  autoCalculate:false, allowBackdate:false, backdateDays:0,   rules:['Must be applied at least 2 days in advance','Cannot be applied for today or past dates','Balance will be deducted upon approval', isUnlimited ? 'Unlimited AL' : `Staff has ${alBal} days available`] },
            'HALF_DAY_AL': { name:'Half Day Annual Leave',    balance:alBal,  requiresAttachment:false, fixedDays:0.5,  maxDays:null,  autoCalculate:false, allowBackdate:false, backdateDays:0,   isHalfDay:true, rules:['Must be applied at least 2 days in advance','Counted as 0.5 days','Select AM or PM', isUnlimited ? 'Unlimited AL' : `Staff has ${alBal} days available`] },
            'EL':          { name:'Emergency Leave',          balance:alBal,  requiresAttachment:false, fixedDays:null, maxDays:null,  autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['Can be backdated up to 118 days', isUnlimited ? 'Unlimited AL' : `Staff has ${alBal} days available`] },
            'HALF_DAY_EL': { name:'Half Day Emergency Leave', balance:alBal,  requiresAttachment:false, fixedDays:0.5,  maxDays:null,  autoCalculate:false, allowBackdate:true,  backdateDays:118, isHalfDay:true, rules:['Can be backdated up to 118 days','Counted as 0.5 days','Select AM or PM', isUnlimited ? 'Unlimited AL' : `Staff has ${alBal} days available`] },
            'MC':          { name:'Medical Leave',            balance:mcBal,  requiresAttachment:true,  fixedDays:null, maxDays:null,  autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['MC attachment is required','Can be backdated up to 118 days', isUnlimited ? 'Unlimited MC' : `Staff has ${mcBal} days available`] },
            'CL':          { name:'Compassionate Leave',      balance:null,   requiresAttachment:false, fixedDays:3,    maxDays:null,  autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Exactly 3 consecutive calendar days','End date auto-calculated','Can be backdated up to 118 days','Not deducted from leave balance'] },
            'MRL':         { name:'Married Leave',            balance:null,   requiresAttachment:false, fixedDays:3,    maxDays:null,  autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Exactly 3 consecutive calendar days','End date auto-calculated','Can be backdated up to 118 days','Not deducted from leave balance'] },
            'WFH':         { name:'Work From Home',           balance:null,   requiresAttachment:false, fixedDays:null, maxDays:null,  autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['Can be backdated up to 118 days','Not deducted from leave balance'] },
            'ML':          { name:'Maternity Leave',          balance:null,   requiresAttachment:true,  fixedDays:null, maxDays:98,   autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Maximum 98 calendar days','End date auto-calculated','Can be backdated up to 118 days','Exempt from daily leave limit','Supporting documents required'] },
            'PL':          { name:'Paternity Leave',          balance:null,   requiresAttachment:true,  fixedDays:null, maxDays:7,    autoCalculate:true,  allowBackdate:true,  backdateDays:118, rules:['Maximum 7 calendar days','End date auto-calculated','Can be backdated up to 118 days','Exempt from daily leave limit','Supporting documents required'] },
            'RL':          { name:'Replacement Leave',        balance:null,   requiresAttachment:false, fixedDays:null, maxDays:null,  autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['For rest days/public holidays worked','Can be backdated up to 118 days','Not deducted from leave balance'] },
            'SL':          { name:'Special Leave',            balance:null,   requiresAttachment:false, fixedDays:null, maxDays:null,  autoCalculate:false, allowBackdate:true,  backdateDays:118, rules:['Admin remark is MANDATORY','Can be backdated up to 118 days','Not deducted from leave balance','For special circumstances not covered by other types'] },
        };
        return configs[leaveType] || null;
    }

    const singleDayTypes = ['AL', 'EL', 'MC', 'WFH', 'RL', 'SL', 'HALF_DAY_AL', 'HALF_DAY_EL'];

    // ─── On staff select change ─────────────────────────────────────
    userSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];

        // Reset form
        leaveTypeSelect.innerHTML = '<option value="">Select Leave Type</option>';
        availBalInput.value = 'Select staff & leave type';
        availBalInput.style.color = '#4a7a76';
        totalDaysInput.value = '0 day(s)';
        startDateInput.value = '';
        endDateInput.value = '';
        halfDayRow.classList.remove('show');
        halfDaySelect.required = false;
        slNoteRow.classList.remove('show');
        slNoteInput.required = false;
        leaveRulesInfo.style.display = 'none';
        const existingWarn = document.getElementById('daily_limit_warning');
        if (existingWarn) existingWarn.remove();

        if (!this.value) {
            staffInfoBox.classList.remove('show');
            leaveTypeHint.textContent = 'Select a staff member first';
            return;
        }

        const role      = opt.dataset.role;
        const position  = opt.dataset.position || 'N/A';
        const alBal     = parseFloat(opt.dataset.al) || 0;
        const mcBal     = parseFloat(opt.dataset.mc) || 0;
        const alUsed    = parseFloat(opt.dataset.alused) || 0;
        const mcUsed    = parseFloat(opt.dataset.mcused) || 0;
        const alTotal   = parseFloat(opt.dataset.altotal) || 0;
        const mcTotal   = parseFloat(opt.dataset.mctotal) || 0;
        const isUnlimited = ['part_time', 'staff_ge'].includes(role);

        // Show staff info box
        const nameText = opt.text.split(' — ')[0];
        staffAvatar.textContent = nameText.charAt(0).toUpperCase();
        staffName.textContent   = nameText;
        staffMeta.textContent   = ucfirstRole(role) + (position !== 'N/A' ? ' · ' + position : '');

        let balHtml = '';
        if (isUnlimited) {
            balHtml += `<span class="bal-chip unlimited"><i class="fas fa-infinity"></i> AL Unlimited (${alUsed} used)</span>`;
            if (role === 'staff_ge') balHtml += `<span class="bal-chip unlimited mc"><i class="fas fa-infinity"></i> MC Unlimited (${mcUsed} used)</span>`;
        } else {
            balHtml += `<span class="bal-chip">AL: ${alBal} days left (${alUsed}/${alTotal} used)</span>`;
            balHtml += `<span class="bal-chip mc">MC: ${mcBal} days left (${mcUsed}/${mcTotal} used)</span>`;
        }
        staffBal.innerHTML = balHtml;
        staffInfoBox.classList.add('show');

        // Populate leave type dropdown
        const types = leaveTypesByRole[role] || leaveTypesByRole['staff'];
        types.forEach(t => {
            const o = document.createElement('option');
            o.value = t.value;
            o.textContent = t.label;
            leaveTypeSelect.appendChild(o);
        });

        leaveTypeHint.textContent = 'Select the type of leave for this staff member';
        window._currentAlBal     = alBal;
        window._currentMcBal     = mcBal;
        window._currentIsUnlimited = isUnlimited;
    });

    // ─── On leave type change ───────────────────────────────────────
    leaveTypeSelect.addEventListener('change', function () {
        const sel = this.value;
        const alBal = window._currentAlBal || 0;
        const mcBal = window._currentMcBal || 0;
        const isUnlimited = window._currentIsUnlimited || false;

        halfDayRow.classList.remove('show');
        halfDaySelect.required = false;
        halfDaySelect.value = '';
        slNoteRow.classList.remove('show');
        slNoteInput.required = false;
        leaveRulesInfo.style.display = 'none';
        startDateInput.value = '';
        endDateInput.value = '';
        totalDaysInput.value = '0 day(s)';
        const existingWarn = document.getElementById('daily_limit_warning');
        if (existingWarn) existingWarn.remove();

        if (!sel) {
            availBalInput.value = 'Select staff & leave type';
            availBalInput.style.color = '#4a7a76';
            return;
        }

        const cfg = getLeaveConfig(sel, alBal, mcBal, isUnlimited);
        if (!cfg) return;

        // Half day
        if (cfg.isHalfDay) {
            halfDayRow.classList.add('show');
            halfDaySelect.required = true;
            endDateInput.readOnly = true;
        } else {
            endDateInput.readOnly = false;
        }

        // SL approval note
        if (sel === 'SL') {
            slNoteRow.classList.add('show');
            slNoteInput.required = true;
        }

        // Balance display
        if (cfg.balance !== null) {
            availBalInput.value = isUnlimited ? 'Unlimited' : cfg.balance + ' days available';
            availBalInput.style.color = isUnlimited ? '#22c55e' : (cfg.balance > 0 ? '#0EA5A0' : '#ef4444');
        } else if (cfg.fixedDays && cfg.fixedDays !== 0.5) {
            availBalInput.value = 'Fixed ' + cfg.fixedDays + ' days';
            availBalInput.style.color = '#f59e0b';
        } else if (cfg.fixedDays === 0.5) {
            availBalInput.value = 'Half Day (0.5 days)';
            availBalInput.style.color = '#3b82f6';
        } else if (cfg.maxDays) {
            availBalInput.value = 'Maximum ' + cfg.maxDays + ' days';
            availBalInput.style.color = '#3b82f6';
        } else {
            availBalInput.value = 'No limit (not counted)';
            availBalInput.style.color = '#22c55e';
        }

        // Attachment
        if (cfg.requiresAttachment) {
            attachInput.required = true;
            attachRequired.style.display = 'inline';
            attachNote.innerHTML = '<strong style="color:#ef4444;">MANDATORY: Attachment required!</strong>';
        } else {
            attachInput.required = false;
            attachRequired.style.display = 'none';
            attachNote.innerHTML = 'Upload supporting document if available (PDF, JPG, PNG – Max 2MB).';
        }

        // Min date
        if (cfg.allowBackdate && cfg.backdateDays > 0) {
            const minDate = new Date();
            minDate.setDate(minDate.getDate() - cfg.backdateDays);
            startDateInput.min = minDate.toISOString().split('T')[0];
        } else {
            // AL: must be future, at least 3 days ahead
            const minFuture = new Date();
            minFuture.setDate(minFuture.getDate() + 2);
            startDateInput.min = minFuture.toISOString().split('T')[0];
        }

        // End date readonly for single day / auto-calculate
        if (cfg.autoCalculate || cfg.isHalfDay) {
            endDateInput.readOnly = true;
        } else if (singleDayTypes.includes(sel)) {
            endDateInput.readOnly = true;
            if (startDateInput.value) { endDateInput.value = startDateInput.value; calculateTotalDays(); }
        } else {
            endDateInput.readOnly = false;
        }

        // Rules
        leaveRulesTitle.textContent = cfg.name + ' – Important Rules';
        leaveRulesList.innerHTML = cfg.rules.map(r => '<li>' + r + '</li>').join('');
        leaveRulesInfo.style.display = 'block';

        checkDailyLimit();
    });

    // ─── On start date change ───────────────────────────────────────
    startDateInput.addEventListener('change', function () {
        const sel = leaveTypeSelect.value;
        if (!sel) return;
        const alBal = window._currentAlBal || 0;
        const mcBal = window._currentMcBal || 0;
        const cfg = getLeaveConfig(sel, alBal, mcBal, false);
        const sd = this.value;

        if (cfg && cfg.autoCalculate && sd) {
            const start = new Date(sd); let end;
            if (sel === 'CL' || sel === 'MRL') { end = new Date(start); end.setDate(end.getDate() + 2); }
            else if (sel === 'ML') { end = new Date(start); end.setDate(end.getDate() + 97); }
            else if (sel === 'PL') { end = new Date(start); end.setDate(end.getDate() + 6); }
            if (end) { endDateInput.value = end.toISOString().split('T')[0]; calculateTotalDays(); }
        } else if (cfg && cfg.isHalfDay && sd) {
            endDateInput.value = sd;
            totalDaysInput.value = '0.5 day (Half Day)';
            totalDaysInput.style.color = '#0EA5A0';
        } else if (singleDayTypes.includes(sel) && sd) {
            endDateInput.value = sd; calculateTotalDays();
        } else {
            endDateInput.min = sd; calculateTotalDays();
        }

        checkDailyLimit();
    });

    endDateInput.addEventListener('change', function () { calculateTotalDays(); checkDailyLimit(); });
    halfDaySelect.addEventListener('change', calculateTotalDays);

    // ─── Calculate total days ───────────────────────────────────────
    function calculateTotalDays() {
        const s = startDateInput.value, e = endDateInput.value, sel = leaveTypeSelect.value;
        if (!s || !e) { totalDaysInput.value = '0 day(s)'; totalDaysInput.style.color = '#0EA5A0'; return; }
        const alBal = window._currentAlBal || 0;
        const mcBal = window._currentMcBal || 0;
        const cfg = getLeaveConfig(sel, alBal, mcBal, false);
        if (cfg && cfg.isHalfDay) { totalDaysInput.value = '0.5 day (Half Day)'; totalDaysInput.style.color = '#0EA5A0'; return; }
        const start = new Date(s), end = new Date(e);
        if (end < start) { totalDaysInput.value = 'Invalid dates'; totalDaysInput.style.color = '#ef4444'; return; }
        const days = Math.ceil(Math.abs(end - start) / (1000 * 60 * 60 * 24)) + 1;
        totalDaysInput.value = days + ' day(s)';
        totalDaysInput.style.color = '#0EA5A0';
        if (cfg) {
            if (cfg.fixedDays && cfg.fixedDays !== 0.5 && days !== cfg.fixedDays) {
                totalDaysInput.style.color = '#ef4444';
                alert('Warning: ' + cfg.name + ' must be exactly ' + cfg.fixedDays + ' days.');
            }
            if (cfg.maxDays && days > cfg.maxDays) {
                totalDaysInput.style.color = '#ef4444';
                alert('Warning: ' + cfg.name + ' cannot exceed ' + cfg.maxDays + ' days.');
            }
        }
    }

    // ─── Check daily limit ──────────────────────────────────────────
    async function checkDailyLimit() {
        const s  = startDateInput.value;
        const e  = endDateInput.value;
        const lt = leaveTypeSelect.value;
        const existing = document.getElementById('daily_limit_warning');
        if (existing) existing.remove();
        if (!s || !e || !lt || ['ML','PL'].includes(lt)) return;
        try {
            const res = await fetch('/leave/check-daily-limit', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ start_date: s, end_date: e, leave_type: lt })
            });
            const data = await res.json();
            if (data.hasLimit && !data.isExempt) showDailyLimitWarning(data);
        } catch (err) { console.error(err); }
    }

    function showDailyLimitWarning(data) {
        let cls, statusText, msg;
        const parts = [];
        if (data.approvedCount > 0) parts.push(data.approvedCount + ' staff approved');
        if (data.pendingCount  > 0) parts.push(data.pendingCount  + ' staff pending');
        if (data.waitingCount  > 0) parts.push(data.waitingCount  + ' staff waiting');

        if (data.willBeWaitingList) {
            cls = 'lv-lim-waiting'; statusText = 'WAITING LIST';
            msg = `Application will be on <strong>WAITING LIST</strong> — daily limit (2 staff) already reached for selected date(s).`;
        } else if (data.totalCount > 0) {
            cls = 'lv-lim-pending'; statusText = 'PENDING';
            msg = `<strong>${data.position}</strong> applicant for these dates. Status will be <strong>PENDING</strong>.`;
        } else {
            cls = 'lv-lim-first'; statusText = 'PENDING';
            msg = `No other applications for these dates. Status will be <strong>PENDING</strong>.`;
        }

        const title = parts.length ? parts.join(' + ') + ' for these dates' : 'No other applications for these dates';
        const html = `<div id="daily_limit_warning" class="lv-limit-box ${cls}">
            <div class="lv-lim-title">${title}</div>
            <div class="lv-lim-meta">
                <span>Position: <strong>${data.position}</strong> applicant</span>
                <span class="lv-lim-badge">Expected: ${statusText}</span>
            </div>
            <div class="lv-lim-msg">${msg}</div>
            ${data.affectedDates?.length ? `<div class="lv-lim-dates"><strong>Affected dates:</strong> ${data.affectedDates.join(', ')}</div>` : ''}
        </div>`;
        leaveRulesInfo.insertAdjacentHTML('beforebegin', html);
    }

    // ─── Helper ─────────────────────────────────────────────────────
    function ucfirstRole(role) {
        return role.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase());
    }

    // ─── Auto dismiss alerts ─────────────────────────────────────────
    ['alertSuccess', 'alertError', 'alertWarning'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => { el.style.transition = 'opacity 1s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 1000); }, 5000);
    });
});
</script>
</body>
</html>
