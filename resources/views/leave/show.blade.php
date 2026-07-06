<!-- C:\laragon\www\om_system\resources\views\leave\show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application Details | O&M HRCare</title>
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
            --font:        'Poppins', sans-serif;
            --red: #ef4444; --amber: #f59e0b; --green: #22c55e; --blue: #3b82f6;
            --accent: #0EA5A0; --white: #ffffff;
        }
        body { font-family: var(--font); background: var(--off-white); color: var(--text-main); font-size: 14px; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .dashboard-layout { display: flex; min-height: 100vh; }
        .dashboard-main   { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        /* ── TOPBAR ── */
        .topbar {
            background: #fff; border-bottom: 1px solid var(--border);
            padding: 0 28px; height: 60px; display: flex; align-items: center;
            position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04);
        }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb a { color: var(--text-muted); transition: color 0.2s; }
        .topbar-breadcrumb a:hover { color: var(--teal-bright); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }

        /* ── CONTENT ── */
        .page-content { padding: 24px 28px; flex: 1; }

        /* ── DETAIL CARD ── */
        .detail-wrapper { max-width: 800px; }
        .detail-card { background: #fff; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }

        /* Card Header */
        .detail-card-head { background: var(--teal-base); padding: 24px 28px; color: #fff; }
        .detail-card-head h3 { font-size: 18px; font-weight: 600; margin: 0 0 4px; }
        .detail-card-head p  { font-size: 12px; opacity: 0.75; margin: 0 0 14px; }

        /* Status Badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 20px;
            font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .status-pending               { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
        .status-approved              { background: rgba(34,197,94,0.25);   color: #86efac; border: 1px solid rgba(34,197,94,0.4); }
        .status-rejected              { background: rgba(239,68,68,0.25);   color: #fca5a5; border: 1px solid rgba(239,68,68,0.4); }
        .status-cancelled             { background: rgba(107,114,128,0.25); color: #d1d5db; border: 1px solid rgba(107,114,128,0.4); }
        .status-waiting-list          { background: rgba(59,130,246,0.25);  color: #93c5fd; border: 1px solid rgba(59,130,246,0.4); }
        .status-special-case-approved { background: rgba(139,92,246,0.25);  color: #c4b5fd; border: 1px solid rgba(139,92,246,0.4); }

        /* Card Body */
        .detail-card-body { padding: 24px 28px; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .detail-item { display: flex; flex-direction: column; gap: 5px; }
        .detail-item.full { grid-column: 1 / -1; }
        .detail-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
        .detail-label i { color: var(--teal-bright); font-size: 11px; }
        .detail-value { font-size: 14px; font-weight: 600; color: var(--text-main); }
        .detail-value.accent { font-size: 24px; color: var(--teal-bright); }

        /* Half day badge */
        .half-day-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; margin-left: 6px; }
        .half-day-badge.am { background: rgba(245,158,11,0.12); color: #92400e; }
        .half-day-badge.pm { background: rgba(139,92,246,0.12); color: #5b21b6; }

        /* Attachment box */
        .attachment-box { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: var(--off-white); border-radius: 8px; border: 1px solid var(--border); margin-top: 4px; }
        .attachment-box-left { display: flex; align-items: center; gap: 12px; }
        .attachment-icon { width: 42px; height: 42px; background: var(--teal-bright); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .attachment-box-left h5 { font-size: 13px; font-weight: 600; color: var(--text-main); margin: 0 0 2px; }
        .attachment-box-left p  { font-size: 11px; color: var(--text-muted); margin: 0; }
        .btn-download { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--teal-bright); color: #fff; border-radius: 7px; font-size: 12px; font-weight: 600; transition: background 0.2s; }
        .btn-download:hover { background: #0c9490; color: #fff; }

        /* Info boxes */
        .info-box { padding: 14px 16px; border-radius: 8px; margin-top: 16px; border-left: 3px solid; }
        .info-box-approved  { background: rgba(34,197,94,0.08);  border-color: var(--green); }
        .info-box-rejected  { background: rgba(239,68,68,0.08);  border-color: var(--red); }
        .info-box-special   { background: rgba(139,92,246,0.08); border-color: #8b5cf6; }
        .info-box h5 { font-size: 12px; font-weight: 700; margin: 0 0 8px; display: flex; align-items: center; gap: 6px; }
        .info-box-approved h5 { color: #166534; }
        .info-box-rejected h5 { color: #991b1b; }
        .info-box-special  h5 { color: #5b21b6; }
        .info-box p  { font-size: 12px; margin: 4px 0 0; color: var(--text-main); }

        /* Divider */
        .divider { height: 1px; background: var(--border); margin: 20px 0; }

        /* Action buttons */
        .action-row { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-back { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); border-radius: 7px; font-family: var(--font); font-size: 12px; font-weight: 600; transition: all 0.2s; cursor: pointer; text-decoration: none; }
        .btn-back:hover { background: #e0f0f0; color: var(--text-main); }
        .btn-cancel { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: rgba(239,68,68,0.08); color: var(--red); border: 1px solid rgba(239,68,68,0.2); border-radius: 7px; font-family: var(--font); font-size: 12px; font-weight: 600; transition: all 0.2s; cursor: pointer; width: 100%; justify-content: center; }
        .btn-cancel:hover { background: var(--red); color: #fff; border-color: var(--red); }
        .btn-cancel:disabled { opacity: 0.35; cursor: not-allowed !important; }

        @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } .action-row { flex-direction: column; } .page-content { padding: 16px; } }
    </style>
</head>
<body>
<div class="dashboard-layout">

    @include('components.sidebar2')

    <main class="dashboard-main">

        <div class="topbar">
            <div class="topbar-breadcrumb">
                <i class="fas fa-home"></i>
                <span style="opacity:.4;">›</span>
                <a href="{{ route('leave.index') }}">My Leave</a>
                <span style="opacity:.4;">›</span>
                <a href="{{ route('leave.my-applications') }}">My Applications</a>
                <span style="opacity:.4;">›</span>
                <span class="current">Application #{{ $application->id }}</span>
            </div>
        </div>

        <div class="page-content">
            <div class="detail-wrapper">
                <div class="detail-card">

                    <!-- Card Header -->
                    <div class="detail-card-head">
                        <h3><i class="fas fa-file-alt" style="margin-right:8px;opacity:0.8;"></i>Leave Application #{{ $application->id }}</h3>
                        <p>Applied on {{ $application->created_at->format('d F Y, h:i A') }}</p>
                        <span class="status-badge status-{{ str_replace('_','-',$application->status) }}">
                            @if($application->status === 'waiting_list') <i class="fas fa-hourglass-half"></i> Waiting List
                            @elseif($application->status === 'special_case_approved') <i class="fas fa-star"></i> Special Case Approved
                            @elseif($application->status === 'approved') <i class="fas fa-check-circle"></i> Approved
                            @elseif($application->status === 'rejected') <i class="fas fa-times-circle"></i> Rejected
                            @elseif($application->status === 'cancelled') <i class="fas fa-ban"></i> Cancelled
                            @else <i class="fas fa-clock"></i> Pending @endif
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="detail-card-body">
                        <div class="detail-grid">

                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-tag"></i> Leave Type</span>
                                <span class="detail-value">
                                    {{ $application->leave_type_name }}
                                    @if($application->is_half_day)
                                        <span class="half-day-badge {{ strtolower($application->half_day_period) }}">{{ $application->half_day_period }}</span>
                                    @endif
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-calculator"></i> Total Days</span>
                                <span class="detail-value accent">{{ $application->total_days }} {{ $application->total_days == 1 ? 'day' : 'days' }}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-calendar-day"></i> Start Date</span>
                                <span class="detail-value">
                                    {{ $application->start_date->format('d F Y') }}
                                    <small style="color:var(--text-muted);font-weight:400;">({{ $application->start_date->format('l') }})</small>
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-calendar-check"></i> End Date</span>
                                <span class="detail-value">
                                    {{ $application->end_date->format('d F Y') }}
                                    <small style="color:var(--text-muted);font-weight:400;">({{ $application->end_date->format('l') }})</small>
                                </span>
                            </div>

                            <div class="detail-item full">
                                <span class="detail-label"><i class="fas fa-comment"></i> Reason</span>
                                <span class="detail-value" style="font-weight:400;white-space:pre-wrap;line-height:1.8;">{{ $application->reason }}</span>
                            </div>

                        </div>

                        <!-- Attachment -->
                        @if($application->attachment)
                        <div class="attachment-box">
                            <div class="attachment-box-left">
                                <div class="attachment-icon"><i class="fas fa-paperclip"></i></div>
                                <div>
                                    <h5>Attachment Available</h5>
                                    <p>Medical certificate or supporting document</p>
                                </div>
                            </div>
                            <a href="{{ route('leave.download-attachment', $application->id) }}" class="btn-download">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                        @endif

                        <!-- Approval Info -->
                        @if(in_array($application->status, ['approved', 'special_case_approved']))
                        <div class="info-box info-box-approved">
                            <h5><i class="fas fa-check-circle"></i> Approval Information</h5>
                            <p><strong>Approved By:</strong> {{ $application->approvedBy->name ?? 'N/A' }}</p>
                            <p><strong>Approved On:</strong> {{ $application->approved_at ? $application->approved_at->format('d F Y, h:i A') : 'N/A' }}</p>
                        </div>
                        @endif

                        <!-- Special Case Info -->
                        @if($application->status === 'special_case_approved')
                        <div class="info-box info-box-special">
                            <h5><i class="fas fa-star"></i> Special Case Approval</h5>
                            <p>This application was approved despite exceeding the daily leave limit.</p>
                            @if($application->approval_note)
                                <p style="margin-top:6px;"><strong>Admin Note:</strong> {{ $application->approval_note }}</p>
                            @endif
                        </div>
                        @endif

                        <!-- Cancellation Info -->
                        @if($application->status === 'cancelled' && $application->approvedBy)
                        <div class="info-box" style="background:rgba(107,114,128,0.08);border-color:#6b7280;">
                            <h5 style="color:#374151;"><i class="fas fa-ban"></i> Cancellation Information</h5>
                            @if($application->approvedBy->id === $application->user_id)
                                <p><strong>Cancelled By:</strong> {{ $application->approvedBy->name }} (Self)</p>
                            @else
                                <p><strong>Cancelled By:</strong> {{ $application->approvedBy->name }}</p>
                            @endif
                            <p><strong>Cancelled On:</strong> {{ $application->approved_at->format('d F Y, h:i A') }}</p>
                        </div>
                        @endif

                        <!-- Rejection Info -->
                        @if($application->status === 'rejected')
                        <div class="info-box info-box-rejected">
                            <h5><i class="fas fa-times-circle"></i> Application Rejected</h5>
                            <p><strong>Rejected By:</strong> {{ $application->approvedBy->name ?? 'N/A' }}</p>
                            <p><strong>Rejected On:</strong> {{ $application->approved_at ? $application->approved_at->format('d F Y, h:i A') : 'N/A' }}</p>
                        </div>
                        @endif

                        <div class="divider"></div>

                        <!-- Actions -->
                        <div class="action-row">
                            <a href="{{ route('leave.my-applications') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Applications</a>

                            @php
                                $cannotCancel = !in_array(Auth::user()->role, ['admin','superadmin']) && \Carbon\Carbon::today('Asia/Kuala_Lumpur')->gte(\Carbon\Carbon::parse($application->start_date));
                            @endphp

                            @if(in_array($application->status, ['pending','waiting_list']))
                                @if($cannotCancel)
                                    <button class="btn-cancel" disabled><i class="fas fa-ban"></i> Cannot Cancel (Leave Already Started/Passed)</button>
                                @else
                                    <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="flex:1;">
                                        @csrf
                                        <button type="submit" class="btn-cancel" onclick="return confirm('Cancel this application?')"><i class="fas fa-times"></i> Cancel Application</button>
                                    </form>
                                @endif
                            @endif

                            @if(in_array($application->status, ['approved','special_case_approved']))
                                @if($cannotCancel)
                                    <button class="btn-cancel" disabled><i class="fas fa-ban"></i> Cannot Cancel (Leave Already Started/Passed)</button>
                                @else
                                    <form method="POST" action="{{ route('leave.cancel-approved', $application->id) }}" style="flex:1;">
                                        @csrf
                                        <button type="submit" class="btn-cancel" onclick="return confirm('⚠️ Cancel this APPROVED leave?\n\nBalance will be restored.\n\nAre you sure?')"><i class="fas fa-ban"></i> Cancel Approved Leave</button>
                                    </form>
                                @endif
                            @endif

                            @if($application->status === 'rejected')
                                <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="flex:1;">
                                    @csrf
                                    <button type="submit" class="btn-cancel" onclick="return confirm('Cancel this rejected application?')"><i class="fas fa-times"></i> Cancel Application</button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
</body>
</html>
