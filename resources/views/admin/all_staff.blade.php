<!-- C:\laragon\www\om_system\resources\views\admin\all_staff.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Staff | O&M HRCare</title>
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

        /* Search in topbar */
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

        /* ── STAT CARDS ── */
        .stats-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
        .stat-card {
            background: #fff; border-radius: 10px; padding: 16px 18px;
            border: 1px solid var(--border); box-shadow: var(--shadow-sm);
            display: flex; align-items: center; gap: 14px; transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(6,62,60,0.1); }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 17px; }
        .stat-card:nth-child(1) .stat-icon { background: rgba(14,165,160,0.1);  color: var(--teal-bright); }
        .stat-card:nth-child(2) .stat-icon { background: rgba(245,158,11,0.1);  color: var(--amber); }
        .stat-card:nth-child(3) .stat-icon { background: rgba(34,197,94,0.1);   color: var(--green); }
        .stat-card:nth-child(4) .stat-icon { background: rgba(239,68,68,0.08);  color: var(--red); }
        .stat-info h3 { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); margin-bottom: 3px; }
        .stat-info h2 { font-size: 24px; font-weight: 700; color: var(--text-main); line-height: 1; }
        .stat-card:nth-child(1) .stat-info h2 { color: var(--teal-bright); }
        .stat-card:nth-child(2) .stat-info h2 { color: var(--amber); }
        .stat-card:nth-child(3) .stat-info h2 { color: var(--green); }
        .stat-card:nth-child(4) .stat-info h2 { color: var(--red); }

        /* ── TABLE CONTAINER ── */
        .table-container { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
        .table-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .table-header h3 { font-size: 13px; color: var(--text-main); margin: 0; font-weight: 700; }
        .table-header-actions { display: flex; align-items: center; gap: 8px; }
        .filter-select {
            padding: 6px 28px 6px 10px; border: 1px solid var(--border); border-radius: 7px;
            font-family: var(--font); font-size: 12px; color: var(--text-main); background: var(--off-white);
            outline: none; cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath fill='%230EA5A0' d='M1 1l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 9px center;
            transition: border-color 0.2s;
        }
        .filter-select:focus { border-color: var(--teal-bright); }
        .btn-refresh { width: 32px; height: 32px; border-radius: 7px; background: rgba(14,165,160,0.1); border: none; color: var(--teal-bright); cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .btn-refresh:hover { background: var(--teal-bright); color: #fff; }

        /* ── TABLE ── */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; border-collapse: collapse; min-width: 700px; }
        .data-table thead tr { background: var(--off-white); }
        .data-table th { padding: 10px 14px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: var(--text-muted); text-align: left; white-space: nowrap; border-bottom: 1px solid var(--border); }
        .data-table td { padding: 12px 14px; font-size: 12px; color: var(--text-main); border-bottom: 1px solid rgba(14,165,160,0.06); vertical-align: middle; }
        .data-table tbody tr:hover { background: #f7fdfd; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        /* ── STAFF NAME CELL ── */
        .staff-name-cell { display: flex; align-items: center; gap: 10px; }
        .staff-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: var(--teal-bright); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; text-transform: uppercase;
        }
        .staff-id-badge { font-size: 11px; font-weight: 600; color: var(--text-muted); background: var(--off-white); padding: 2px 8px; border-radius: 5px; border: 1px solid var(--border); }

        /* ── ROLE BADGES ── */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .badge-admin      { background: rgba(139,92,246,0.1);  color: #5b21b6; }
        .badge-superadmin { background: rgba(239,68,68,0.1);   color: #991b1b; }
        .badge-staff      { background: rgba(14,165,160,0.1);  color: #0a5654; }
        .badge-intern     { background: rgba(59,130,246,0.1);  color: #1e40af; }
        .badge-part-time  { background: rgba(245,158,11,0.1);  color: #92400e; }
        .badge-staff-ge   { background: rgba(34,197,94,0.1);   color: #166534; }

        /* ── STATUS BADGES ── */
        .status { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; white-space: nowrap; }
        .status.active   { background: rgba(34,197,94,0.1);   color: #166534; }
        .status.pending  { background: rgba(245,158,11,0.1);  color: #92400e; }
        .status.inactive { background: rgba(107,114,128,0.1); color: #374151; }

        /* ── ACTION BUTTONS ── */
        .actions { display: flex; align-items: center; gap: 6px; }
        .btn-icon { width: 30px; height: 30px; border-radius: 7px; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; transition: all 0.2s; text-decoration: none; }
        .btn-view     { background: rgba(14,165,160,0.1);   color: var(--teal-bright); }
        .btn-view:hover     { background: var(--teal-bright); color: #fff; }
        .btn-edit     { background: rgba(59,130,246,0.1);   color: var(--blue); }
        .btn-edit:hover     { background: var(--blue); color: #fff; }
        .btn-deactivate { background: rgba(239,68,68,0.08); color: var(--red); }
        .btn-deactivate:hover { background: var(--red); color: #fff; }
        .btn-reactivate { background: rgba(34,197,94,0.1); color: var(--green); }
        .btn-reactivate:hover { background: var(--green); color: #fff; }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 60px 24px; text-align: center; }
        .empty-state i { font-size: 48px; color: rgba(14,165,160,0.2); display: block; margin-bottom: 16px; }
        .empty-state h3 { font-size: 16px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; }
        .empty-state p  { font-size: 13px; color: var(--text-muted); }

        @media (max-width: 1200px) { .stats-cards { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px)  { .stats-cards { grid-template-columns: repeat(2, 1fr); } .page-content { padding: 16px; } .topbar-search input { width: 160px; } }
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
                <span class="current">All Staff</span>
            </div>
            <div class="topbar-search">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search staff...">
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
                <h2><i class="fas fa-users" style="color:var(--teal-bright);margin-right:8px;"></i>Manage Staff</h2>
                <p>View and manage all registered staff members</p>
            </div>

            <!-- Stat Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-info"><h3>Total Staff</h3><h2>{{ $totalCount }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    <div class="stat-info"><h3>Pending</h3><h2>{{ $allStaff->where('status','pending')->count() }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-info"><h3>Active</h3><h2>{{ \App\Models\User::where('status','active')->count() }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-ban"></i></div>
                    <div class="stat-info"><h3>Inactive</h3><h2>{{ $allStaff->where('status','inactive')->count() }}</h2></div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>Staff Directory</h3>
                    <div class="table-header-actions">
                        <select class="filter-select" id="statusFilter">
                            <option value="all">All Staff</option>
                            <option value="pending">Pending</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <button class="btn-refresh" onclick="location.reload()" title="Refresh"><i class="fas fa-sync-alt"></i></button>
                    </div>
                </div>

                @if($allStaff->count() > 0)
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Staff ID</th>
                                <th>Name</th>
                                <th>IC / Passport No.</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="staffTableBody">
                            @foreach($allStaff as $staff)
                            <tr data-status="{{ $staff->status }}">
                                <td><span class="staff-id-badge">{{ $staff->id }}</span></td>
                                <td>
                                    <div class="staff-name-cell">
                                        <div class="staff-avatar">{{ strtoupper(substr($staff->name, 0, 2)) }}</div>
                                        <span style="font-weight:500;">{{ $staff->name }}</span>
                                    </div>
                                </td>
                                {{-- ── UPDATED: ic → id_number + id_type ── --}}
                                <td style="color:var(--text-muted);">
                                    {{ $staff->id_type === 'ic'
                                        ? substr($staff->id_number,0,6).'-'.substr($staff->id_number,6,2).'-'.substr($staff->id_number,8,4)
                                        : $staff->id_number }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ strtolower(str_replace('_','-',$staff->role)) }}">
                                        <i class="fas {{ in_array($staff->role, ['admin','superadmin']) ? 'fa-user-shield' : 'fa-user' }}"></i>
                                        {{ ucfirst(str_replace('_',' ',$staff->role)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status {{ $staff->status }}">
                                        @if($staff->status === 'active') <i class="fas fa-circle" style="font-size:6px;"></i>
                                        @elseif($staff->status === 'pending') <i class="fas fa-clock" style="font-size:9px;"></i>
                                        @else <i class="fas fa-circle" style="font-size:6px;opacity:0.5;"></i> @endif
                                        {{ strtoupper($staff->status) }}
                                    </span>
                                </td>
                                <td style="color:var(--text-muted);">{{ $staff->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.view-staff', $staff->id) }}" class="btn-icon btn-view" title="View Details"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.edit-staff', $staff->id) }}" class="btn-icon btn-edit" title="Edit Staff"><i class="fas fa-edit"></i></a>

                                        @if($staff->role === 'staff')
                                            @if($staff->status === 'active')
                                                <form method="POST" action="{{ route('admin.deactivate-staff', $staff->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-deactivate" title="Deactivate" onclick="return confirm('Deactivate {{ $staff->name }}?')">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @elseif($staff->status === 'inactive')
                                                <form method="POST" action="{{ route('admin.reactivate-staff', $staff->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-icon btn-reactivate" title="Reactivate" onclick="return confirm('Reactivate {{ $staff->name }}?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
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
                    <i class="fas fa-users-slash"></i>
                    <h3>No Staff Found</h3>
                    <p>There are no staff members registered yet.</p>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput  = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const tableBody    = document.getElementById('staffTableBody');
    const rows         = tableBody ? Array.from(tableBody.getElementsByTagName('tr')) : [];

    function applyFilters() {
        const search = searchInput ? searchInput.value.toLowerCase() : '';
        const status = statusFilter ? statusFilter.value : 'all';
        rows.forEach(row => {
            const text       = row.textContent.toLowerCase();
            const rowStatus  = row.getAttribute('data-status');
            const matchSearch = text.includes(search);
            const matchStatus = status === 'all' || rowStatus === status;
            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    }

    if (searchInput)  searchInput.addEventListener('keyup', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);

    // Auto-hide alerts
    ['alertSuccess','alertError'].forEach(id => {
        const el = document.getElementById(id);
        if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 5000);
    });
});
</script>
</body>
</html>
