{{-- C:\laragon\www\om_system\resources\views\admin\leave\intern-entitlements.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Leave Balances | O&M HRCare</title>
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
            --pink:   #ec4899;
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

        /* ── NOTICE BOX ── */
        .notice-box {
            background: rgba(245,158,11,0.08);
            border: 1px solid rgba(245,158,11,0.25);
            border-left: 3px solid var(--amber);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        .notice-box i    { color: var(--amber); font-size: 16px; margin-top: 1px; flex-shrink: 0; }
        .notice-box h4   { font-size: 12px; font-weight: 700; color: #92400e; margin-bottom: 5px; }
        .notice-box p    { font-size: 12px; color: #92400e; line-height: 1.6; }

        /* ── STAT CARDS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }
        .stat-card  { background: #fff; border-radius: 12px; border: 1px solid var(--border); padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: var(--shadow-sm); transition: transform .2s, box-shadow .2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon  { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .stat-icon.pink   { background: rgba(236,72,153,0.1);  color: var(--pink); }
        .stat-icon.purple { background: rgba(124,58,237,0.1);  color: var(--purple); }
        .stat-icon.red    { background: rgba(239,68,68,0.1);   color: var(--red); }
        .stat-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted); margin-bottom: 4px; }
        .stat-value { font-size: 28px; font-weight: 700; color: var(--text-main); line-height: 1; }

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

        /* ── INTERN NAME CELL ── */
        .intern-avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--pink); color: #fff; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .staff-cell    { display: flex; align-items: center; gap: 10px; }
        .staff-name-text { font-weight: 600; font-size: 12px; }

        /* ── INTERNSHIP PERIOD ── */
        .period-text  { font-size: 11px; color: var(--text-muted); }
        .warning-pill {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(245,158,11,0.1); color: #92400e;
            border: 1px solid rgba(245,158,11,0.3); border-radius: 20px;
            padding: 2px 10px; font-size: 10px; font-weight: 700;
        }

        /* ── YEAR TAG ── */
        .year-tag { font-size: 12px; font-weight: 600; color: var(--text-muted); }
        .na-text  { font-size: 11px; color: var(--text-muted); }

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

        /* ── RESPONSIVE ── */
        @media (max-width: 900px)  { .stats-grid { grid-template-columns: 1fr 1fr; } }
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
                <span class="current">Intern Leave Balances</span>
            </div>
        </div>

        <div class="page-content">

            <div class="page-header">
                <div>
                    <div class="page-title">
                        <i class="fas fa-user-graduate" style="color:var(--pink);margin-right:8px;"></i>Intern Leave Balances
                    </div>
                    <div class="page-subtitle">View intern leave entitlements for entire internship period</div>
                </div>
                <a href="{{ route('admin.leave.staff-entitlements') }}" class="btn btn-primary">
                    <i class="fas fa-users"></i> View Staff Entitlements
                </a>
            </div>

            {{-- Notice --}}
            <div class="notice-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    <h4>📌 Important Notes</h4>
                    <p>
                        Intern entitlements are for the <strong>ENTIRE internship period</strong> (not per year).
                        Total: <strong>5 AL/EL + 5 MC</strong> for the whole internship.
                        Interns must set their internship start/end dates in their profile before applying for leave.
                    </p>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon pink"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div class="stat-label">Total Interns</div>
                        <div class="stat-value">{{ $interns->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-umbrella-beach"></i></div>
                    <div>
                        <div class="stat-label">Total AL Used</div>
                        <div class="stat-value">{{ $interns->sum(function($i) { return $i->entitlement->annual_leave_used ?? 0; }) }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-notes-medical"></i></div>
                    <div>
                        <div class="stat-label">Total MC Used</div>
                        <div class="stat-value">{{ $interns->sum(function($i) { return $i->entitlement->medical_leave_used ?? 0; }) }}</div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title"><i class="fas fa-table"></i> Intern Leave Balances</div>
                    <button class="icon-btn" onclick="location.reload()" title="Refresh"><i class="fas fa-sync-alt"></i></button>
                </div>

                @if($interns->count() > 0)
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr class="group-row">
                                <th class="col-plain" rowspan="2" style="text-align:left;">#</th>
                                <th class="col-plain" rowspan="2" style="text-align:left;">Intern Name</th>
                                <th class="col-plain" rowspan="2" style="text-align:left;">Internship Period</th>
                                <th class="col-plain" rowspan="2">Year</th>
                                <th class="col-al" colspan="3">Annual Leave (AL/EL)</th>
                                <th class="col-mc" colspan="3">Medical Leave (MC)</th>
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
                        <tbody>
                            @foreach($interns as $index => $intern)
                            <tr>
                                <td class="left-align">{{ $index + 1 }}</td>

                                <td class="left-align">
                                    <div class="staff-cell">
                                        <div class="intern-avatar">{{ substr($intern->name, 0, 1) }}</div>
                                        <span class="staff-name-text">{{ $intern->name }}</span>
                                    </div>
                                </td>

                                <td class="left-align">
                                    @if($intern->internship_start_date && $intern->internship_end_date)
                                        <span class="period-text">
                                            {{ \Carbon\Carbon::parse($intern->internship_start_date)->format('d/m/Y') }} —
                                            {{ \Carbon\Carbon::parse($intern->internship_end_date)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="warning-pill"><i class="fas fa-exclamation-triangle"></i> Dates not set</span>
                                    @endif
                                </td>

                                <td>
                                    @if(isset($intern->entitlement))
                                        <span class="year-tag">{{ $intern->entitlement->year }}</span>
                                    @else
                                        <span class="na-text">N/A</span>
                                    @endif
                                </td>

                                {{-- AL --}}
                                <td class="cell-al">
                                    @if(isset($intern->entitlement)) <strong>{{ $intern->entitlement->annual_leave_total }}</strong>
                                    @else <span class="na-text">—</span> @endif
                                </td>
                                <td class="cell-al">
                                    @if(isset($intern->entitlement)) <span class="bal-used-al">{{ $intern->entitlement->annual_leave_used }}</span>
                                    @else <span class="na-text">—</span> @endif
                                </td>
                                <td class="cell-al">
                                    @if(isset($intern->entitlement))
                                        <span class="{{ $intern->entitlement->annual_leave_balance <= 2 ? 'bal-low' : 'bal-healthy' }}">
                                            {{ $intern->entitlement->annual_leave_balance }}
                                        </span>
                                    @else <span class="na-text">—</span> @endif
                                </td>

                                {{-- MC --}}
                                <td class="cell-mc">
                                    @if(isset($intern->entitlement)) <strong>{{ $intern->entitlement->medical_leave_total }}</strong>
                                    @else <span class="na-text">—</span> @endif
                                </td>
                                <td class="cell-mc">
                                    @if(isset($intern->entitlement)) <span class="bal-used-mc">{{ $intern->entitlement->medical_leave_used }}</span>
                                    @else <span class="na-text">—</span> @endif
                                </td>
                                <td class="cell-mc">
                                    @if(isset($intern->entitlement))
                                        <span class="{{ $intern->entitlement->medical_leave_balance <= 2 ? 'bal-low' : 'bal-healthy' }}">
                                            {{ $intern->entitlement->medical_leave_balance }}
                                        </span>
                                    @else <span class="na-text">—</span> @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align:right;padding-right:14px;color:var(--text-muted);font-size:11px;">TOTAL</td>
                                <td class="cell-al"><strong>{{ $interns->sum(function($i) { return $i->entitlement->annual_leave_total ?? 0; }) }}</strong></td>
                                <td class="cell-al"><span class="bal-used-al">{{ $interns->sum(function($i) { return $i->entitlement->annual_leave_used ?? 0; }) }}</span></td>
                                <td class="cell-al"><span class="bal-healthy">{{ $interns->sum(function($i) { return $i->entitlement->annual_leave_balance ?? 0; }) }}</span></td>
                                <td class="cell-mc"><strong>{{ $interns->sum(function($i) { return $i->entitlement->medical_leave_total ?? 0; }) }}</strong></td>
                                <td class="cell-mc"><span class="bal-used-mc">{{ $interns->sum(function($i) { return $i->entitlement->medical_leave_used ?? 0; }) }}</span></td>
                                <td class="cell-mc"><span class="bal-healthy">{{ $interns->sum(function($i) { return $i->entitlement->medical_leave_balance ?? 0; }) }}</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-user-graduate"></i>
                    <h3>No Interns Found</h3>
                    <p>There are no active interns in the system.</p>
                </div>
                @endif
            </div>

            {{-- Legend --}}
            <div class="legend-card">
                <div class="legend-title"><i class="fas fa-info-circle"></i> Legend</div>
                <div class="legend-grid">
                    <div class="legend-item"><span class="legend-dot" style="background:var(--green);"></span> Balance &gt; 2 days (Healthy)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--red);"></span> Balance ≤ 2 days (Low)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--teal-bright);"></span> Annual Leave (AL/EL)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:#dc2626;"></span> Medical Leave (MC)</div>
                    <div class="legend-item"><span class="legend-dot" style="background:var(--amber);"></span> Internship dates not set</div>
                </div>
            </div>

        </div>
    </main>
</div>
</body>
</html>
