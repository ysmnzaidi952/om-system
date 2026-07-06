<!-- C:\laragon\www\om_system\resources\views\admin\pending_staff.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals | O&M HRCare</title>
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
        .topbar-search { position: relative; }
        .topbar-search input {
            padding: 7px 14px 7px 34px; border: 1px solid var(--border);
            border-radius: 7px; font-family: var(--font); font-size: 12px;
            color: var(--text-main); background: var(--off-white); outline: none;
            width: 220px; transition: all 0.2s;
        }
        .topbar-search input:focus { border-color: var(--teal-bright); background: #fff; box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        .topbar-search i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 11px; pointer-events: none; }

        /* ── CONTENT ── */
        .page-content { padding: 24px 28px; flex: 1; }
        .page-header  { margin-bottom: 20px; }
        .page-header h2 { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .page-header p  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ── ALERTS ── */
        .alert { display: flex; align-items: center; gap: 9px; padding: 11px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: rgba(34,197,94,0.08);  color: #166534; border: 1px solid rgba(34,197,94,0.2);  border-left: 3px solid var(--green); }
        .alert-error   { background: rgba(239,68,68,0.08);  color: #dc2626; border: 1px solid rgba(239,68,68,0.2);  border-left: 3px solid var(--red); }

        /* ── STAT CARD ── */
        .stats-cards { display: grid; grid-template-columns: 200px; gap: 14px; margin-bottom: 20px; }
        .stat-card { background: #fff; border-radius: 10px; padding: 16px 18px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 14px; }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 17px; background: rgba(245,158,11,0.1); color: var(--amber); }
        .stat-info h3 { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); margin-bottom: 3px; }
        .stat-info h2 { font-size: 28px; font-weight: 700; color: var(--amber); line-height: 1; }

        /* ── TABLE CONTAINER ── */
        .table-container { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
        .table-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-header h3 { font-size: 13px; color: var(--text-main); margin: 0; font-weight: 700; }
        .btn-refresh { width: 32px; height: 32px; border-radius: 7px; background: rgba(14,165,160,0.1); border: none; color: var(--teal-bright); cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .btn-refresh:hover { background: var(--teal-bright); color: #fff; }

        /* ── TABLE ── */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; border-collapse: collapse; min-width: 560px; }
        .data-table thead tr { background: var(--off-white); }
        .data-table th { padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); text-align: left; white-space: nowrap; border-bottom: 1px solid var(--border); }
        .data-table td { padding: 12px 14px; font-size: 12px; color: var(--text-main); border-bottom: 1px solid rgba(14,165,160,0.06); vertical-align: middle; }
        .data-table tbody tr:hover { background: #f7fdfd; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        /* ── STAFF NAME CELL ── */
        .staff-name-cell { display: flex; align-items: center; gap: 10px; }
        .staff-avatar { width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0; background: var(--teal-bright); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .staff-name-cell strong { display: block; font-weight: 600; font-size: 13px; }

        /* ── ROLE BADGE ── */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; margin-top: 3px; }
        .badge-staff     { background: rgba(14,165,160,0.1);  color: #0a5654; }
        .badge-intern    { background: rgba(59,130,246,0.1);  color: #1e40af; }
        .badge-admin     { background: rgba(139,92,246,0.1);  color: #5b21b6; }
        .badge-part-time { background: rgba(245,158,11,0.1);  color: #92400e; }
        .badge-staff-ge  { background: rgba(34,197,94,0.1);   color: #166534; }

        /* ── ACTION BUTTONS ── */
        .actions { display: flex; align-items: center; gap: 6px; }
        .btn-icon { width: 32px; height: 32px; border-radius: 7px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.2s; }
        .btn-approve { background: rgba(34,197,94,0.1); color: var(--green); }
        .btn-approve:hover { background: var(--green); color: #fff; }
        .btn-reject  { background: rgba(239,68,68,0.08); color: var(--red); }
        .btn-reject:hover  { background: var(--red); color: #fff; }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 64px 24px; text-align: center; }
        .empty-state i { font-size: 48px; color: rgba(34,197,94,0.3); display: block; margin-bottom: 16px; }
        .empty-state h3 { font-size: 16px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 13px; color: var(--text-muted); }

        @media (max-width: 768px) { .page-content { padding: 16px; } .topbar-search input { width: 160px; } }
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
                <span class="current">Account Approval</span>
            </div>
            <div class="topbar-search">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search pending staff...">
            </div>
        </div>

        <div class="page-content">

            @if(session('success'))
                <div class="alert alert-success" id="alertSuccess"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" id="alertError"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
            @endif

            <div class="page-header">
                <h2><i class="fas fa-user-clock" style="color:var(--teal-bright);margin-right:8px;"></i>Pending Staff Approvals</h2>
                <p>Review and approve or reject new staff registration requests</p>
            </div>

            <!-- Stat -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-info"><h3>Pending Approvals</h3><h2>{{ $pendingStaff->count() }}</h2></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>Awaiting Approval</h3>
                    <button class="btn-refresh" onclick="location.reload()" title="Refresh"><i class="fas fa-sync-alt"></i></button>
                </div>

                @if($pendingStaff->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>ID Number</th>
                                <th>Registered Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
                            @foreach($pendingStaff as $index => $staff)
                            <tr>
                                <td style="color:var(--text-muted);font-weight:600;">{{ $index + 1 }}</td>
                                <td>
                                    <div class="staff-name-cell">
                                        <div class="staff-avatar">{{ strtoupper(substr($staff->name, 0, 2)) }}</div>
                                        <div>
                                            <strong>{{ $staff->name }}</strong>
                                            <span class="badge badge-{{ strtolower(str_replace('_','-',$staff->role)) }}">{{ ucfirst(str_replace('_',' ',$staff->role)) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:var(--text-muted);">
                                    <span style="font-size:10px;font-weight:600;color:var(--text-muted);display:block;margin-bottom:2px;">
                                        {{ $staff->id_type === 'passport' ? '🛂 Passport' : '🪪 IC' }}
                                    </span>
                                    {{ $staff->id_type === 'ic'
                                        ? substr($staff->id_number,0,6).'-'.substr($staff->id_number,6,2).'-'.substr($staff->id_number,8,4)
                                        : $staff->id_number }}
                                </td>
                                <td style="color:var(--text-muted);">{{ $staff->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    <div class="actions">
                                        <form method="POST" action="{{ route('admin.approve-staff', $staff->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-icon btn-approve" title="Approve" onclick="return confirm('Approve {{ $staff->name }}?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reject-staff', $staff->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-icon btn-reject" title="Reject" onclick="return confirm('Reject and delete {{ $staff->name }}? This cannot be undone!')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
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
                    <p>No pending approvals at this time. All registrations have been processed.</p>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody   = document.getElementById('staffTableBody');
    const rows        = tableBody ? Array.from(tableBody.getElementsByTagName('tr')) : [];

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            rows.forEach(row => { row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none'; });
        });
    }

    ['alertSuccess','alertError'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 5000);
    });
});
</script>
</body>
</html>
