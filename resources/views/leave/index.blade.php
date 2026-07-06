<!-- C:\laragon\www\om_system\resources\views\leave\index.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Leave | O&M HRCare</title>
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
            padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04);
        }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }

        /* ── CONTENT ── */
        .page-content { padding: 24px 28px; flex: 1; }
        .page-header  { margin-bottom: 20px; }
        .page-header h2 { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .page-header p  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ── ALERTS ── */
        .alert { display: flex; align-items: flex-start; gap: 9px; padding: 11px 14px; border-radius: 8px; margin-bottom: 14px; font-size: 13px; }
        .alert-success { background: rgba(34,197,94,0.08);  color: #166534; border: 1px solid rgba(34,197,94,0.2);  border-left: 3px solid var(--green); }
        .alert-error   { background: rgba(239,68,68,0.08);  color: #dc2626; border: 1px solid rgba(239,68,68,0.2);  border-left: 3px solid var(--red); }
        .alert-warning { background: rgba(245,158,11,0.08); color: #92400e; border: 1px solid rgba(245,158,11,0.2); border-left: 3px solid var(--amber); }

        /* ── STAT CARDS ── */
        .stats-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 16px; }
        .stats-card {
            background: #fff; border-radius: 10px; padding: 16px 18px;
            border: 1px solid var(--border); box-shadow: var(--shadow-sm);
            display: flex; align-items: center; gap: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stats-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(6,62,60,0.1); }
        .stats-icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stats-icon i { font-size: 18px; }
        .stats-card:nth-child(1) .stats-icon { background: rgba(14,165,160,0.1); }
        .stats-card:nth-child(1) .stats-icon i { color: var(--teal-bright); }
        .stats-card:nth-child(2) .stats-icon { background: rgba(239,68,68,0.08); }
        .stats-card:nth-child(2) .stats-icon i { color: var(--red); }
        .stats-card:nth-child(3) .stats-icon { background: rgba(59,130,246,0.08); }
        .stats-card:nth-child(3) .stats-icon i { color: var(--blue); }
        .stats-info h3 { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); margin: 0 0 4px; }
        .stats-info h2 { font-size: 22px; font-weight: 700; color: var(--text-main); margin: 0 0 2px; line-height: 1; }
        .stats-card:nth-child(1) .stats-info h2 { color: var(--teal-bright); }
        .stats-card:nth-child(2) .stats-info h2 { color: var(--red); }
        .stats-card:nth-child(3) .stats-info h2 { color: var(--blue); }
        .stats-info p { font-size: 11px; color: var(--text-muted); margin: 0; }

        /* ── QUICK ACTIONS ── */
        .quick-actions-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px; }
        .quick-action-card {
            background: #fff; border-radius: 10px; padding: 14px 18px;
            border: 1px solid var(--border); box-shadow: var(--shadow-sm);
            display: flex; align-items: center; gap: 13px;
            transition: all 0.2s; position: relative; overflow: hidden;
        }
        .quick-action-card::before { content: ''; position: absolute; inset: 0; background: var(--teal-bright); opacity: 0; transition: opacity 0.2s; z-index: 0; }
        .quick-action-card:hover::before { opacity: 1; }
        .quick-action-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(14,165,160,0.25); }
        .quick-action-card > * { position: relative; z-index: 1; }
        .quick-action-icon { width: 40px; height: 40px; border-radius: 9px; background: rgba(14,165,160,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.2s; }
        .quick-action-card:hover .quick-action-icon { background: rgba(255,255,255,0.2); }
        .quick-action-icon i { font-size: 16px; color: var(--teal-bright); transition: all 0.2s; }
        .quick-action-card:hover .quick-action-icon i { color: #fff; }
        .quick-action-card h4 { font-size: 13px; color: var(--text-main); margin: 0; font-weight: 600; transition: all 0.2s; }
        .quick-action-card:hover h4 { color: #fff; }

        /* ── TABLE ── */
        .table-container { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
        .table-header { padding: 14px 18px; border-bottom: 1px solid var(--border); }
        .table-header h3 { font-size: 13px; color: var(--text-main); margin: 0; font-weight: 700; }
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; border-collapse: collapse; min-width: 600px; }
        .data-table thead tr { background: var(--off-white); }
        .data-table th { padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); text-align: left; white-space: nowrap; border-bottom: 1px solid var(--border); }
        .data-table td { padding: 11px 14px; font-size: 12px; color: var(--text-main); border-bottom: 1px solid rgba(14,165,160,0.06); vertical-align: middle; }
        .data-table tbody tr:hover { background: #f7fdfd; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .badge-al, .badge-el          { background: rgba(14,165,160,0.1);   color: #0a5654; }
        .badge-mc, .badge-ml, .badge-pl { background: rgba(239,68,68,0.08);  color: #991b1b; }
        .badge-mrl                    { background: rgba(236,72,153,0.08);  color: #9d174d; }
        .badge-cl                     { background: rgba(139,92,246,0.08);  color: #5b21b6; }
        .badge-wfh                    { background: rgba(59,130,246,0.08);  color: #1e40af; }
        .badge-rl                     { background: rgba(245,158,11,0.08);  color: #92400e; }
        .badge-sl                     { background: rgba(107,114,128,0.08); color: #374151; }
        .half-day-badge { display: inline-block; padding: 1px 6px; border-radius: 4px; font-size: 9px; font-weight: 700; margin-left: 4px; }
        .half-day-badge.am { background: rgba(245,158,11,0.12); color: #92400e; }
        .half-day-badge.pm { background: rgba(139,92,246,0.12); color: #5b21b6; }
        .status { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .status-pending               { background: rgba(245,158,11,0.1);  color: #92400e; }
        .status-approved              { background: rgba(34,197,94,0.1);   color: #166534; }
        .status-rejected              { background: rgba(239,68,68,0.1);   color: #991b1b; }
        .status-cancelled             { background: rgba(107,114,128,0.1); color: #374151; }
        .status-waiting-list          { background: rgba(59,130,246,0.1);  color: #1e40af; }
        .status-special-case-approved { background: rgba(139,92,246,0.1);  color: #5b21b6; }

        /* ── ACTION BUTTONS ── */
        .actions { display: flex; align-items: center; gap: 6px; }
        .btn-icon { width: 30px; height: 30px; border-radius: 7px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.2s; text-decoration: none; }
        .btn-view   { background: rgba(14,165,160,0.1); color: var(--teal-bright); }
        .btn-view:hover   { background: var(--teal-bright); color: #fff; }
        .btn-delete { background: rgba(239,68,68,0.08); color: var(--red); }
        .btn-delete:hover { background: var(--red); color: #fff; }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 48px 24px; text-align: center; }
        .empty-state i { font-size: 36px; color: rgba(14,165,160,0.3); display: block; margin-bottom: 12px; }
        .empty-state h3 { font-size: 14px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 12px; color: var(--text-muted); }

        @media (max-width: 991px) { .stats-cards { grid-template-columns: repeat(2, 1fr); } .quick-actions-row { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .stats-cards { grid-template-columns: 1fr; } .page-content { padding: 16px; } }
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
                <span class="current">My Leave</span>
            </div>
        </div>

        <div class="page-content">

            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {!! session('success') !!}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning" id="alertWarning"><i class="fas fa-exclamation-circle"></i> {{ session('warning') }}</div>
            @endif

            <div class="page-header">
                <h2><i class="fas fa-umbrella-beach" style="color:var(--teal-bright);margin-right:8px;"></i>My Leave Balance</h2>
                <p>Manage your annual and medical leave</p>
            </div>

            <!-- Stats -->
            <div class="stats-cards">
                <div class="stats-card">
                    <div class="stats-icon"><i class="fas fa-calendar-day"></i></div>
                    <div class="stats-info">
                        <h3>Annual Leave (AL/EL)</h3>
                        @if(in_array(Auth::user()->role, ['part_time','staff_ge']))
                            <h2>{{ $entitlement->annual_leave_used }} Used</h2>
                            <p>No yearly limit (Unlimited)</p>
                        @else
                            <h2>{{ $entitlement->annual_leave_balance }} Days</h2>
                            <p>Used: {{ $entitlement->annual_leave_used }} / {{ $entitlement->annual_leave_total }}</p>
                        @endif
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon"><i class="fas fa-notes-medical"></i></div>
                    <div class="stats-info">
                        <h3>Medical Leave (MC)</h3>
                        @if(in_array(Auth::user()->role, ['part_time','staff_ge']))
                            <h2>{{ $entitlement->medical_leave_used }} Used</h2>
                            <p>No yearly limit (Unlimited)</p>
                        @else
                            <h2>{{ $entitlement->medical_leave_balance }} Days</h2>
                            <p>Used: {{ $entitlement->medical_leave_used }} / {{ $entitlement->medical_leave_total }}</p>
                        @endif
                    </div>
                </div>
                <div class="stats-card">
                    <div class="stats-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="stats-info">
                        <h3>This Month</h3>
                        <h2>{{ $alThisMonth + $mcThisMonth }} Days</h2>
                        <p>AL: {{ $alThisMonth }} | MC: {{ $mcThisMonth }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions-row">
                <a href="{{ route('leave.apply') }}" class="quick-action-card">
                    <div class="quick-action-icon"><i class="fas fa-plus-circle"></i></div>
                    <h4>Apply Leave</h4>
                </a>
                <a href="{{ route('leave.my-applications') }}" class="quick-action-card">
                    <div class="quick-action-icon"><i class="fas fa-history"></i></div>
                    <h4>My Applications</h4>
                </a>
            </div>

            <!-- Recent Applications -->
            <div class="table-container">
                <div class="table-header">
                    <h3>Recent Applications</h3>
                </div>

                @if($recentApplications->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date Applied</th>
                                <th>Type</th>
                                <th>Leave Period</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentApplications as $application)
                            <tr>
                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        if ($application->leave_type === 'HALF_DAY_AL') { $displayType = 'AL 1/2'; $badgeClass = 'badge-al'; }
                                        elseif ($application->leave_type === 'HALF_DAY_EL') { $displayType = 'EL 1/2'; $badgeClass = 'badge-el'; }
                                        else { $displayType = $application->leave_type; $badgeClass = 'badge-' . strtolower(str_replace('_','-',$application->leave_type)); }
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        @if(in_array($application->leave_type, ['AL','EL','HALF_DAY_AL','HALF_DAY_EL'])) <i class="fas fa-umbrella-beach"></i>
                                        @elseif(in_array($application->leave_type, ['MC','ML','PL'])) <i class="fas fa-notes-medical"></i>
                                        @elseif($application->leave_type === 'MRL') <i class="fas fa-heart"></i>
                                        @elseif($application->leave_type === 'CL') <i class="fas fa-hands-praying"></i>
                                        @elseif($application->leave_type === 'WFH') <i class="fas fa-home"></i>
                                        @else <i class="fas fa-calendar"></i> @endif
                                        {{ $displayType }}
                                    </span>
                                    @if($application->is_half_day)
                                        <span class="half-day-badge {{ strtolower($application->half_day_period) }}">{{ $application->half_day_period }}</span>
                                    @endif
                                </td>
                                <td style="white-space:nowrap;">{{ $application->start_date->format('d/m/Y') }} – {{ $application->end_date->format('d/m/Y') }}</td>
                                <td><strong style="color:var(--teal-bright);">{{ $application->total_days }} day(s)</strong></td>
                                <td>
                                    <span class="status status-{{ str_replace('_','-',$application->status) }}">
                                        @if($application->status === 'waiting_list') <i class="fas fa-hourglass-half"></i> WAITING
                                        @elseif($application->status === 'special_case_approved') <i class="fas fa-star"></i> SPECIAL
                                        @else {{ strtoupper($application->status) }} @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('leave.show', $application->id) }}" class="btn-icon btn-view" title="View Details"><i class="fas fa-eye"></i></a>

                                        @if(in_array($application->status, ['pending','waiting_list']))
                                            @php
                                                $cannotCancel = !in_array(Auth::user()->role, ['admin','superadmin']) && \Carbon\Carbon::today('Asia/Kuala_Lumpur')->gte(\Carbon\Carbon::parse($application->start_date));
                                            @endphp
                                            @if($cannotCancel)
                                                <button class="btn-icon btn-delete" disabled style="opacity:.35;cursor:not-allowed;" title="Cannot cancel — leave already started/passed"><i class="fas fa-times"></i></button>
                                            @else
                                                <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-delete" title="Cancel" onclick="return confirm('Cancel this application?')"><i class="fas fa-times"></i></button>
                                                </form>
                                            @endif
                                        @endif

                                        @if(in_array($application->status, ['approved','special_case_approved']))
                                            @php
                                                $cannotCancel = !in_array(Auth::user()->role, ['admin','superadmin']) && \Carbon\Carbon::today('Asia/Kuala_Lumpur')->gte(\Carbon\Carbon::parse($application->start_date));
                                            @endphp
                                            @if($cannotCancel)
                                                <button class="btn-icon btn-delete" disabled style="opacity:.35;cursor:not-allowed;" title="Cannot cancel — leave already started/passed"><i class="fas fa-ban"></i></button>
                                            @else
                                                <form method="POST" action="{{ route('leave.cancel-approved', $application->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-delete" title="Cancel Approved Leave" onclick="return confirm('⚠️ Cancel this APPROVED leave?\n\nBalance will be restored.\n\nAre you sure?')"><i class="fas fa-ban"></i></button>
                                                </form>
                                            @endif
                                        @endif

                                        @if($application->status === 'rejected')
                                            <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-icon btn-delete" title="Cancel Rejected Application" onclick="return confirm('Cancel this rejected application?')"><i class="fas fa-times"></i></button>
                                            </form>
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
                    <h3>No Applications Yet</h3>
                    <p>You haven't applied for any leave yet. Click "Apply Leave" to get started.</p>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    ['alertWarning'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 10000);
    });
    ['.alert-success','.alert-error'].forEach(cls => {
        const el = document.querySelector(cls);
        if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 5000);
    });
});
</script>
</body>
</html>
