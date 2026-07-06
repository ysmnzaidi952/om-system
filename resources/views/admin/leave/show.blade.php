{{-- C:\laragon\www\om_system\resources\views\admin\leave\show.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details | O&M HRCare</title>
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

        .topbar-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }

        .topbar-breadcrumb a:hover { color: var(--teal-bright); }
        .topbar-breadcrumb .sep { opacity: .5; }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 600; }

        /* ── PAGE CONTENT ── */
        .page-content {
            padding: 24px 28px;
            flex: 1;
            max-width: 860px;
        }

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

        /* ── WAITING LIST ALERT ── */
        .waiting-list-notice {
            background: rgba(59,130,246,0.08);
            border: 1px solid rgba(59,130,246,0.25);
            border-left: 3px solid var(--blue);
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
        }

        .waiting-list-notice i { color: var(--blue); font-size: 16px; margin-top: 1px; flex-shrink: 0; }
        .waiting-list-notice h4 { font-size: 13px; font-weight: 700; color: #1e40af; margin-bottom: 4px; }
        .waiting-list-notice p  { font-size: 12px; color: #1e40af; line-height: 1.5; }

        /* ── DETAIL CARD ── */
        .detail-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .detail-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-card-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
        }

        .detail-card-title i { color: var(--teal-bright); }

        .detail-card-body { padding: 0; }

        /* ── INFO ROWS ── */
        .info-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 16px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            align-items: start;
        }

        .info-row:last-child { border-bottom: none; }

        .info-row.full { grid-template-columns: 1fr; }

        .info-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            padding-top: 1px;
        }

        .info-value {
            font-size: 13px;
            color: var(--text-main);
            line-height: 1.5;
        }

        /* ── LEAVE TYPE BADGE ── */
        .leave-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .leave-al, .leave-el,
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
            font-size: 11px;
            font-weight: 700;
        }

        .status-pending         { background: rgba(245,158,11,0.12); color: #92400e; }
        .status-approved        { background: rgba(34,197,94,0.12);  color: #166534; }
        .status-rejected        { background: rgba(239,68,68,0.12);  color: #991b1b; }
        .status-waiting-list    { background: rgba(59,130,246,0.12); color: #1e40af; }
        .status-cancelled       { background: rgba(107,114,128,0.12);color: #374151; }
        .status-special-case-approved { background: rgba(124,58,237,0.12); color: #5b21b6; }

        .special-case-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #5b21b6;
            margin-left: 8px;
        }

        /* ── HALF DAY TAG ── */
        .half-day-tag {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 4px;
            background: rgba(14,165,160,0.1);
            color: var(--teal-base);
            margin-left: 6px;
        }

        /* ── DAYS VALUE ── */
        .days-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--teal-bright);
        }

        /* ── APPROVAL NOTE BOX ── */
        .approval-note-box {
            background: rgba(245,158,11,0.08);
            border: 1px solid rgba(245,158,11,0.25);
            border-left: 3px solid var(--amber);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 600;
            color: #92400e;
        }

        /* ── REJECTION REASON BOX ── */
        .rejection-box {
            background: rgba(239,68,68,0.06);
            border: 1px solid rgba(239,68,68,0.2);
            border-left: 3px solid var(--red);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            color: #991b1b;
        }

        /* ── ATTACHMENT ── */
        .attachment-image {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            transition: box-shadow .2s;
            margin-top: 8px;
        }

        .attachment-image:hover { box-shadow: var(--shadow-md); }

        .attachment-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .attachment-pdf {
            width: 100%;
            height: 600px;
            border-radius: 8px;
            border: 1px solid var(--border);
            margin-top: 8px;
        }

        .attachment-file {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px;
            background: var(--off-white);
            border-radius: 8px;
            border: 1px solid var(--border);
            text-align: center;
            margin-top: 8px;
        }

        .attachment-file i { font-size: 32px; color: var(--teal-bright); margin-bottom: 8px; }
        .attachment-file p { font-size: 12px; color: var(--text-muted); }

        /* ── ACTION BUTTONS ── */
        .action-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

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

        .btn-secondary { background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--teal-soft); color: var(--teal-base); border-color: var(--teal-bright); }

        .btn-success { background: var(--green); color: #fff; }
        .btn-success:hover { background: #16a34a; }

        .btn-danger { background: var(--red); color: #fff; }
        .btn-danger:hover { background: #dc2626; }

        .btn-warning { background: var(--amber); color: #fff; }
        .btn-warning:hover { background: #d97706; }

        .btn-special { background: var(--amber); color: #fff; }
        .btn-special:hover { background: #d97706; }

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

        .info-box p { font-size: 12px; color: #92400e; line-height: 1.6; }

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

        .char-counter { font-size: 11px; color: var(--text-muted); margin-top: 5px; text-align: right; }
        .char-counter.warn { color: var(--red); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .page-content { padding: 16px; }
            .info-row { grid-template-columns: 1fr; gap: 4px; }
            .info-label { padding-top: 0; }
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
                <a href="{{ route('admin.leave.index') }}">Leave Management</a>
                <span class="sep">›</span>
                <a href="{{ route('admin.leave.all-applications') }}">All Applications</a>
                <span class="sep">›</span>
                <span class="current">Details</span>
            </div>
        </div>

        <div class="page-content">

            {{-- Page Header --}}
            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-file-alt" style="color:var(--teal-bright);margin-right:8px;"></i>
                        Leave Application Details
                    </div>
                    <div class="page-subtitle">Full details for this leave request</div>
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

            {{-- Waiting List Notice --}}
            @if($application->status === 'waiting_list')
            <div class="waiting-list-notice">
                <i class="fas fa-info-circle"></i>
                <div>
                    <h4>Waiting List Application</h4>
                    <p>This application is on the waiting list because the daily limit (2 staff) was reached. You can approve it as a special case after meeting with the staff member.</p>
                </div>
            </div>
            @endif

            {{-- Application Info Card --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title">
                        <i class="fas fa-info-circle"></i> Application Information
                    </div>
                </div>
                <div class="detail-card-body">

                    <div class="info-row">
                        <div class="info-label">Staff Name</div>
                        <div class="info-value">{{ $application->user->name }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $application->user->position ?? 'N/A' }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Leave Type</div>
                        <div class="info-value">
                            <span class="leave-badge leave-{{ strtolower(str_replace('_', '-', $application->leave_type)) }}">
                                {{ $application->leave_type }} — {{ $application->leave_type_name }}
                            </span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Start Date</div>
                        <div class="info-value">{{ $application->start_date->format('d/m/Y') }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">End Date</div>
                        <div class="info-value">{{ $application->end_date->format('d/m/Y') }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Total Days</div>
                        <div class="info-value">
                            <span class="days-value">{{ $application->total_days }} day(s)</span>
                            @if($application->is_half_day)
                                <span class="half-day-tag">{{ $application->half_day_period }} — Half Day</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Reason</div>
                        <div class="info-value">{{ $application->reason }}</div>
                    </div>

                    @if($application->attachment)
                    <div class="info-row">
                        <div class="info-label">Attachment</div>
                        <div class="info-value">
                            @php
                                $extension = pathinfo($application->attachment, PATHINFO_EXTENSION);
                                $isImage   = in_array(strtolower($extension), ['jpg','jpeg','png','gif','webp']);
                                $isPdf     = strtolower($extension) === 'pdf';
                            @endphp

                            @if($isImage)
                                <img src="{{ asset('storage/' . $application->attachment) }}"
                                    alt="Attachment"
                                    class="attachment-image"
                                    onclick="window.open('{{ asset('storage/' . $application->attachment) }}', '_blank')">
                                <div class="attachment-hint">
                                    <i class="fas fa-info-circle"></i> Click image to view full size
                                </div>
                            @elseif($isPdf)
                                <embed src="{{ asset('storage/' . $application->attachment) }}"
                                    type="application/pdf"
                                    class="attachment-pdf">
                                <div class="attachment-hint">
                                    <i class="fas fa-file-pdf"></i> PDF Document — Scroll to view all pages
                                </div>
                            @else
                                <div class="attachment-file">
                                    <i class="fas fa-file"></i>
                                    <p>{{ basename($application->attachment) }}</p>
                                    <small>File type: .{{ $extension }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="info-row">
                        <div class="info-label">Applied Date</div>
                        <div class="info-value">{{ $application->created_at->format('d/m/Y h:i A') }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Current Status</div>
                        <div class="info-value">
                            @php
                                $statusMap = [
                                    'pending'               => ['class' => 'status-pending',       'icon' => 'fa-clock',          'label' => 'Pending'],
                                    'approved'              => ['class' => 'status-approved',      'icon' => 'fa-check-circle',   'label' => 'Approved'],
                                    'rejected'              => ['class' => 'status-rejected',      'icon' => 'fa-times-circle',   'label' => 'Rejected'],
                                    'waiting_list'          => ['class' => 'status-waiting-list',  'icon' => 'fa-hourglass-half', 'label' => 'Waiting List'],
                                    'cancelled'             => ['class' => 'status-cancelled',     'icon' => 'fa-ban',            'label' => 'Cancelled'],
                                    'special_case_approved' => ['class' => 'status-special-case-approved', 'icon' => 'fa-star',  'label' => 'Special Case Approved'],
                                ];
                                $st = $statusMap[$application->status] ?? ['class' => 'status-pending', 'icon' => 'fa-circle', 'label' => ucfirst($application->status)];
                            @endphp
                            <span class="status-badge {{ $st['class'] }}">
                                <i class="fas {{ $st['icon'] }}"></i> {{ $st['label'] }}
                            </span>
                            @if($application->status === 'special_case_approved')
                                <span class="special-case-tag">
                                    <i class="fas fa-crown"></i> 3rd Person Approved
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            {{-- Approval Timeline Card --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="detail-card-title">
                        <i class="fas fa-history"></i> Approval Timeline
                    </div>
                </div>
                <div class="detail-card-body">

                    @if($application->approvedBy)
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-user-shield"></i> Approved by Admin</div>
                        <div class="info-value" style="color:#166534;font-weight:600;">{{ $application->approvedBy->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-check-double"></i> Approval Time</div>
                        <div class="info-value">
                            {{ $application->approved_at->format('d/m/Y, h:i A') }}
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">{{ $application->approved_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @elseif(in_array($application->status, ['pending', 'waiting_list']))
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-hourglass-half"></i> Admin Approval</div>
                        <div class="info-value" style="color:var(--text-muted);">
                            @if($application->status === 'waiting_list')
                                Waiting List — Awaiting special case approval
                            @else
                                Waiting for Admin approval
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($application->approved_at)
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-stopwatch"></i> Processing Time</div>
                        <div class="info-value">
                            <span style="font-weight:600;color:var(--teal-bright);">
                                {{ $application->created_at->diffForHumans($application->approved_at, true) }}
                            </span>
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">From application to approval</div>
                        </div>
                    </div>
                    @endif

                    @if($application->rejection_reason)
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-times-circle"></i> Rejection Reason</div>
                        <div class="info-value">
                            <div class="rejection-box">{{ $application->rejection_reason }}</div>
                        </div>
                    </div>
                    @endif

                    @if($application->leave_type === 'SL' && $application->approval_note && in_array($application->status, ['approved','special_case_approved']))
                    <div class="info-row">
                        <div class="info-label"><i class="fas fa-star"></i> Approval Remark</div>
                        <div class="info-value">
                            <div class="approval-note-box">{{ $application->approval_note }}</div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Action Buttons --}}
            @php
                $isPast = \Carbon\Carbon::parse($application->start_date)->lte(\Carbon\Carbon::today('Asia/Kuala_Lumpur'));
            @endphp
            <div class="action-row">
                <a href="{{ route('admin.leave.pending') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Pending
                </a>

                @if($application->status === 'pending' || $application->status === 'waiting_list')

                    {{-- Approve --}}
                    @if($application->leave_type === 'SL')
                        <button type="button" class="btn btn-special"
                            onclick="showSpecialLeaveModal({{ $application->id }}, '{{ $application->user->name }}')">
                            <i class="fas fa-star"></i> Approve Special Leave
                        </button>
                    @else
                        <form method="POST" action="{{ route('admin.leave.approve', $application->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('{{ $application->status === 'waiting_list' ? 'Approve as SPECIAL CASE?' : 'Approve this application?' }}')">
                                <i class="fas fa-check"></i>
                                {{ $application->status === 'waiting_list' ? 'Approve as Special Case' : 'Approve' }}
                            </button>
                        </form>
                    @endif

                    {{-- Cancel --}}
                    <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit"
                            class="btn {{ $isPast ? 'btn-secondary' : 'btn-warning' }}"
                            style="{{ $isPast ? 'opacity:0.4;cursor:not-allowed;' : '' }}"
                            {{ $isPast ? 'disabled' : '' }}
                            {{ !$isPast ? 'onclick="return confirm(\'Cancel this application for ' . addslashes($application->user->name) . '?\')"' : '' }}>
                            <i class="fas fa-ban"></i>
                            {{ $isPast ? 'Cannot Cancel (Past)' : 'Cancel Application' }}
                        </button>
                    </form>

                    {{-- Reject --}}
                    <button type="button" class="btn btn-danger"
                        onclick="showRejectModal({{ $application->id }}, '{{ addslashes($application->user->name) }}')">
                        <i class="fas fa-times"></i> Reject
                    </button>

                @endif

                {{-- Cancel Approved --}}
                @if($application->status === 'approved' || $application->status === 'special_case_approved')
                <form method="POST" action="{{ route('admin.leave.cancel-approved', $application->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning"
                        onclick="return confirm('Cancel this APPROVED leave?\n\n✓ Balance will be restored\n✓ Daily count will be decremented\n✓ Next waiting list (if any) will move to pending')">
                        <i class="fas fa-ban"></i> Cancel Approved Leave
                    </button>
                </form>
                @endif

                {{-- Cancel Rejected --}}
                @if($application->status === 'rejected')
                <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary"
                        onclick="return confirm('Cancel this rejected application for {{ addslashes($application->user->name) }}?')">
                        <i class="fas fa-ban"></i> Cancel Application
                    </button>
                </form>
                @endif

            </div>

        </div>
    </main>
</div>

{{-- ── SPECIAL LEAVE MODAL ── --}}
<div class="modal-overlay" id="specialLeaveModal">
    <div class="modal-box wide">
        <div class="modal-header">
            <h3><i class="fas fa-star" style="color:var(--amber);margin-right:6px;"></i>Approve Special Leave</h3>
            <div class="modal-subtext" id="specialLeaveStaffName"></div>
        </div>
        <form id="specialLeaveForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="info-box">
                    <div class="info-box-title"><i class="fas fa-info-circle"></i> Special Leave Approval</div>
                    <p>
                        You are approving a <strong>Special Leave</strong> application.
                        Please provide a <strong>mandatory remark</strong> explaining why this Special Leave is approved.
                        This is for documentation and audit purposes.
                    </p>
                </div>
                <label class="field-label">Approval Remark <span style="color:var(--red);">*</span></label>
                <textarea class="textarea-field" id="approval_note_show" name="approval_note" rows="5" required maxlength="500"
                    placeholder="Example: Approved for quarantine period as recommended by healthcare provider. Staff will work from home when able during this period."></textarea>
                <div class="char-counter" id="charCountWrapper"><span id="charCountShow">0</span>/500 characters</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeSpecialLeaveModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Approve with Remark
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── REJECT MODAL ── --}}


<script>
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

function showSpecialLeaveModal(applicationId, staffName) {
    document.getElementById('specialLeaveForm').action = '/admin/leave/approve/' + applicationId;
    document.getElementById('specialLeaveStaffName').textContent = 'Approving Special Leave for: ' + staffName;
    document.getElementById('approval_note_show').value = '';
    updateCharCountShow();
    document.getElementById('specialLeaveModal').classList.add('active');
}

function closeSpecialLeaveModal() {
    document.getElementById('specialLeaveModal').classList.remove('active');
    document.getElementById('approval_note_show').value = '';
}

function updateCharCountShow() {
    const len = document.getElementById('approval_note_show').value.length;
    document.getElementById('charCountShow').textContent = len;
    document.getElementById('charCountWrapper').classList.toggle('warn', len > 450);
}

document.getElementById('rejectModal').addEventListener('click', function (e) {
    if (e.target === this) closeRejectModal();
});

document.addEventListener('DOMContentLoaded', function () {
    const approvalNoteShow = document.getElementById('approval_note_show');
    if (approvalNoteShow) approvalNoteShow.addEventListener('input', updateCharCountShow);

    const specialLeaveModal = document.getElementById('specialLeaveModal');
    if (specialLeaveModal) {
        specialLeaveModal.addEventListener('click', function (e) {
            if (e.target === this) closeSpecialLeaveModal();
        });
    }

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
</script>
</body>
</html>
