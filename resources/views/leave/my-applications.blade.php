<!-- C:\laragon\www\om_system\resources\views\leave\my-applications.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications | O&M HRCare</title>
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
        .topbar-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 16px; background: var(--teal-bright); color: #fff;
            border-radius: 7px; font-size: 12px; font-weight: 600; transition: background 0.2s;
        }
        .topbar-btn:hover { background: #0c9490; color: #fff; }

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
        .stats-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 16px; }
        .stat-card {
            background: #fff; border-radius: 10px; padding: 16px 18px;
            border: 1px solid var(--border); box-shadow: var(--shadow-sm);
            display: flex; align-items: center; gap: 14px; transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(6,62,60,0.1); }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 17px; }
        .stat-card:nth-child(1) .stat-icon { background: rgba(245,158,11,0.1);  color: var(--amber); }
        .stat-card:nth-child(2) .stat-icon { background: rgba(59,130,246,0.1);  color: var(--blue); }
        .stat-card:nth-child(3) .stat-icon { background: rgba(34,197,94,0.1);   color: var(--green); }
        .stat-card:nth-child(4) .stat-icon { background: rgba(239,68,68,0.08);  color: var(--red); }
        .stat-info h3 { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); margin-bottom: 3px; }
        .stat-info h2 { font-size: 22px; font-weight: 700; color: var(--text-main); line-height: 1; }
        .stat-card:nth-child(1) .stat-info h2 { color: var(--amber); }
        .stat-card:nth-child(2) .stat-info h2 { color: var(--blue); }
        .stat-card:nth-child(3) .stat-info h2 { color: var(--green); }
        .stat-card:nth-child(4) .stat-info h2 { color: var(--red); }

        /* ── TABLE CONTAINER ── */
        .table-container { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
        .table-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-header h3 { font-size: 13px; color: var(--text-main); margin: 0; font-weight: 700; }
        .btn-refresh { width: 32px; height: 32px; border-radius: 7px; background: rgba(14,165,160,0.1); border: none; color: var(--teal-bright); cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .btn-refresh:hover { background: var(--teal-bright); color: #fff; }

        /* ── SCROLL HINT ── */
        .scroll-hint { margin: 0 18px 12px; padding: 9px 14px; background: rgba(14,165,160,0.06); border-left: 3px solid var(--teal-bright); border-radius: 7px; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .scroll-hint-text { font-size: 12px; color: var(--teal-base); flex: 1; }
        .scroll-hint-text i { margin-right: 5px; color: var(--teal-bright); }
        .scroll-btns { display: flex; gap: 8px; }
        .scroll-btn { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 6px; border: none; cursor: pointer; font-family: var(--font); font-size: 11px; font-weight: 600; transition: all 0.2s; }
        .scroll-btn-left  { background: rgba(14,165,160,0.1); color: var(--teal-base); }
        .scroll-btn-left:hover  { background: rgba(14,165,160,0.2); }
        .scroll-btn-right { background: var(--teal-bright); color: #fff; }
        .scroll-btn-right:hover { background: #0c9490; }

        /* ── TABLE ── */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; scrollbar-width: thick; scrollbar-color: var(--teal-bright) #e0f0f0; }
        .table-responsive::-webkit-scrollbar { height: 8px; }
        .table-responsive::-webkit-scrollbar-track { background: #e0f0f0; border-radius: 10px; }
        .table-responsive::-webkit-scrollbar-thumb { background: var(--teal-bright); border-radius: 10px; }
        .data-table { width: 100%; min-width: 1100px; border-collapse: collapse; }
        .data-table thead tr { background: var(--off-white); }
        .data-table th { padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); text-align: left; white-space: nowrap; border-bottom: 1px solid var(--border); }
        .data-table td { padding: 11px 14px; font-size: 12px; color: var(--text-main); border-bottom: 1px solid rgba(14,165,160,0.06); white-space: nowrap; vertical-align: middle; }
        .data-table tbody tr:hover { background: #f7fdfd; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .badge-al, .badge-el, .badge-half-day-al, .badge-half-day-el { background: rgba(14,165,160,0.1);   color: #0a5654; }
        .badge-mc, .badge-ml, .badge-pl                               { background: rgba(239,68,68,0.08);   color: #991b1b; }
        .badge-mrl  { background: rgba(236,72,153,0.08);  color: #9d174d; }
        .badge-cl   { background: rgba(139,92,246,0.08);  color: #5b21b6; }
        .badge-wfh  { background: rgba(59,130,246,0.08);  color: #1e40af; }
        .badge-rl   { background: rgba(245,158,11,0.08);  color: #92400e; }
        .badge-sl   { background: rgba(107,114,128,0.08); color: #374151; }
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
        .btn-view     { background: rgba(14,165,160,0.15); color: var(--teal-bright); }
        .btn-view:hover     { background: var(--teal-bright); color: #fff; }
        .btn-download { background: rgba(34,197,94,0.12); color: #16a34a; }
        .btn-download:hover { background: var(--green); color: #fff; }
        .btn-delete   { background: rgba(239,68,68,0.08); color: var(--red); }
        .btn-delete:hover   { background: var(--red); color: #fff; }

        /* ── REASON CELL ── */
        .reason-cell { max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block; }

        /* ── PAGINATION ── */
        .lv-pagination { padding: 14px 18px; border-top: 1px solid rgba(14,165,160,0.08); }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 48px 24px; text-align: center; }
        .empty-state i { font-size: 36px; color: rgba(14,165,160,0.3); display: block; margin-bottom: 12px; }
        .empty-state h3 { font-size: 14px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 12px; color: var(--text-muted); margin-bottom: 16px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: var(--teal-bright); color: #fff; border-radius: 7px; font-size: 12px; font-weight: 600; transition: background 0.2s; }
        .btn-primary:hover { background: #0c9490; color: #fff; }

        @media (max-width: 1200px) { .stats-cards { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px)  { .stats-cards { grid-template-columns: repeat(2, 1fr); } .page-content { padding: 16px; } }
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
                <a href="{{ route('leave.index') }}" style="color:var(--text-muted);">My Leave</a>
                <span style="opacity:.4;">›</span>
                <span class="current">My Applications</span>
            </div>
            <a href="{{ route('leave.apply') }}" class="topbar-btn">
                <i class="fas fa-plus-circle"></i> Apply New Leave
            </a>
        </div>

        <div class="page-content">

            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning" id="alertWarning"><i class="fas fa-exclamation-circle"></i> {{ session('warning') }}</div>
            @endif

            <div class="page-header">
                <h2><i class="fas fa-list-alt" style="color:var(--teal-bright);margin-right:8px;"></i>My Leave Applications</h2>
                <p>View all your leave application history</p>
            </div>

            <!-- Stats -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-info"><h3>Pending</h3><h2>{{ $applications->where('status','pending')->count() }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-info"><h3>Waiting List</h3><h2>{{ $applications->where('status','waiting_list')->count() }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info"><h3>Approved</h3><h2>{{ $applications->whereIn('status',['approved','special_case_approved'])->count() }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                    <div class="stat-info"><h3>Rejected</h3><h2>{{ $applications->where('status','rejected')->count() }}</h2></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>All Applications</h3>
                    <button class="btn-refresh" onclick="location.reload()"><i class="fas fa-sync-alt"></i></button>
                </div>

                @if($applications->count() > 0)
                <div class="scroll-hint">
                    <div class="scroll-hint-text"><i class="fas fa-arrow-right"></i> <strong>Tip:</strong> Scroll right to see all columns →</div>
                    <div class="scroll-btns">
                        <button onclick="scrollTable('left')" class="scroll-btn scroll-btn-left"><i class="fas fa-chevron-left"></i> Left</button>
                        <button onclick="scrollTable('right')" class="scroll-btn scroll-btn-right">Right <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="table-responsive" id="applicationsTable">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Applied Date</th>
                                <th>Type</th>
                                <th>Leave Period</th>
                                <th>Days</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $index => $application)
                            <tr>
                                <td>{{ ($applications->currentPage() - 1) * $applications->perPage() + $index + 1 }}</td>
                                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower(str_replace('_','-',$application->leave_type)) }}">
                                        {{ $application->leave_type }}
                                    </span>
                                    @if($application->is_half_day)
                                        <span class="half-day-badge {{ strtolower($application->half_day_period) }}">{{ $application->half_day_period }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $application->start_date->format('d/m/Y') }}</strong><br>
                                    <small style="color:var(--text-muted);">to {{ $application->end_date->format('d/m/Y') }}</small>
                                </td>
                                <td><strong style="color:var(--teal-bright);">{{ $application->total_days }}</strong></td>
                                <td><span class="reason-cell" title="{{ $application->reason }}">{{ $application->reason }}</span></td>
                                <td>
                                    <span class="status status-{{ str_replace('_','-',$application->status) }}">
                                        @if($application->status === 'waiting_list') <i class="fas fa-hourglass-half"></i> Waiting List
                                        @elseif($application->status === 'special_case_approved') <i class="fas fa-star"></i> Special Case
                                        @else {{ strtoupper(str_replace('_',' ',$application->status)) }} @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('leave.show', $application->id) }}" class="btn-icon btn-view" title="View Details"><i class="fas fa-eye"></i></a>

                                        @if($application->attachment)
                                            <a href="{{ route('leave.download-attachment', $application->id) }}" class="btn-icon btn-download" title="Download Attachment"><i class="fas fa-download"></i></a>
                                        @endif

                                        @php
                                            $cannotCancel = !in_array(Auth::user()->role, ['admin','superadmin']) && \Carbon\Carbon::today('Asia/Kuala_Lumpur')->gte(\Carbon\Carbon::parse($application->start_date));
                                        @endphp

                                        @if(in_array($application->status, ['pending','waiting_list']))
                                            @if($cannotCancel)
                                                <button class="btn-icon btn-delete" disabled style="opacity:.35;cursor:not-allowed;" title="Cannot cancel — leave already started/passed"><i class="fas fa-times"></i></button>
                                            @else
                                                <form method="POST" action="{{ route('leave.cancel', $application->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-delete" title="Cancel" onclick="return confirm('Cancel this application?')"><i class="fas fa-times"></i></button>
                                                </form>
                                            @endif
                                        @elseif(in_array($application->status, ['approved','special_case_approved']))
                                            @if($cannotCancel)
                                                <button class="btn-icon btn-delete" disabled style="opacity:.35;cursor:not-allowed;" title="Cannot cancel — leave already started/passed"><i class="fas fa-ban"></i></button>
                                            @else
                                                <form method="POST" action="{{ route('leave.cancel-approved', $application->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-delete" title="Cancel Approved Leave" onclick="return confirm('Cancel this APPROVED leave?\n\nBalance will be restored.')"><i class="fas fa-ban"></i></button>
                                                </form>
                                            @endif
                                        @elseif($application->status === 'rejected')
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

                <div class="lv-pagination">{{ $applications->links() }}</div>
                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Applications Found</h3>
                    <p>You haven't applied for any leave yet.</p>
                    <a href="{{ route('leave.apply') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Apply Leave Now</a>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
function scrollTable(direction) {
    const wrapper = document.getElementById('applicationsTable');
    wrapper.scrollBy({ left: direction === 'left' ? -400 : 400, behavior: 'smooth' });
}
document.addEventListener('DOMContentLoaded', function() {
    ['.alert-success','.alert-error'].forEach(cls => {
        const el = document.querySelector(cls);
        if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 5000);
    });
    const warn = document.getElementById('alertWarning');
    if (warn) setTimeout(() => { warn.style.transition='opacity 1s'; warn.style.opacity='0'; setTimeout(()=>warn.remove(),1000); }, 10000);

    const tbl = document.getElementById('applicationsTable');
    if (tbl && tbl.scrollWidth > tbl.clientWidth) {
        tbl.style.boxShadow = 'inset -10px 0 10px -10px rgba(0,0,0,0.1)';
        tbl.addEventListener('scroll', function() {
            const atEnd = this.scrollLeft >= (this.scrollWidth - this.clientWidth - 1);
            this.style.boxShadow = this.scrollLeft === 0 ? 'inset -10px 0 10px -10px rgba(0,0,0,0.1)' : atEnd ? 'inset 10px 0 10px -10px rgba(0,0,0,0.1)' : 'inset 10px 0 10px -10px rgba(0,0,0,0.1), inset -10px 0 10px -10px rgba(0,0,0,0.1)';
        });
    }
});
</script>
</body>
</html>
