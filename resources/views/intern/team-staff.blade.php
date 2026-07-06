{{-- C:\laragon\www\om_system\resources\views\intern\team-staff.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Staff | O&M HRCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --teal-dark: #042e2c; --teal-base: #0a5654; --teal-bright: #0EA5A0;
            --off-white: #f0fafa; --text-main: #0a2e2c; --text-muted: #4a7a76;
            --border: rgba(14,165,160,0.15); --shadow-sm: 0 4px 24px rgba(6,62,60,0.10);
            --font: 'Poppins', sans-serif; --amber: #f59e0b; --blue: #3b82f6;
            --accent: #0EA5A0; --white: #ffffff;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--off-white); color: var(--text-main); font-size: 14px; line-height: 1.6; }
        a { color: inherit; text-decoration: none; }
        .dashboard-layout { display: flex; min-height: 100vh; }

        /* ══ MAIN ══ */
        .dashboard-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 0 28px; height: 60px; display: flex; align-items: center; position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }
        .page-content { padding: 24px 28px; flex: 1; }
        .page-header { margin-bottom: 24px; }
        .page-header h2 { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .page-header p { font-size: 12px; color: var(--text-muted); margin-top: 2px; }
        .top-stats-row { display: grid; grid-template-columns: repeat(2, 200px); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 10px; padding: 18px 20px; display: flex; align-items: center; gap: 14px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; background: rgba(14,165,160,0.1); color: var(--teal-bright); }
        .stat-icon.blue { background: rgba(59,130,246,0.1); color: var(--blue); }
        .stat-info h3 { font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 2px; }
        .stat-info h2 { font-size: 24px; font-weight: 700; color: var(--text-main); line-height: 1.2; }
        .team-section { margin-bottom: 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); overflow: hidden; }
        .team-header-v2 { padding: 14px 20px; display: flex; align-items: center; }
        .team-title-section { display: flex; align-items: center; gap: 12px; color: #fff; }
        .team-title-section > i { font-size: 18px; opacity: 0.9; }
        .team-title-section h3 { font-size: 14px; font-weight: 600; margin: 0 0 1px; }
        .team-title-section > div > span { font-size: 11px; opacity: 0.8; }
        .team-content-v2 { padding: 14px 18px; }
        .position-section-v2 { margin-bottom: 14px; }
        .position-header-v2 { display: flex; align-items: center; gap: 8px; padding: 7px 12px; background: var(--off-white); border-radius: 7px; margin-bottom: 10px; border-left: 3px solid var(--teal-bright); }
        .position-header-v2 i { font-size: 11px; color: var(--teal-bright); }
        .position-header-v2 > span { font-size: 12px; font-weight: 600; color: var(--text-main); }
        .hou-tag { background: var(--teal-bright); color: #fff; font-size: 10px; font-weight: 700; padding: 1px 7px; border-radius: 10px; letter-spacing: 0.5px; }
        .staff-grid-v2 { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 10px; }
        .staff-card-v2 { display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: var(--off-white); border-radius: 8px; border: 1px solid var(--border); transition: all 0.2s; }
        .staff-card-v2:hover { transform: translateY(-2px); box-shadow: var(--shadow-sm); background: #fff; }
        .staff-avatar-v2 { width: 46px; height: 46px; border-radius: 50%; overflow: hidden; border: 2px solid rgba(255,255,255,0.5); flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; color: #fff; }
        .staff-avatar-v2 img { width: 100%; height: 100%; object-fit: cover; }
        .staff-details-v2 { flex: 1; min-width: 0; }
        .staff-details-v2 h4 { font-size: 13px; font-weight: 600; color: var(--text-main); margin: 0 0 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .staff-contact-v2 { display: flex; flex-direction: column; gap: 2px; }
        .staff-contact-v2 span { font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
        .staff-contact-v2 span i { width: 12px; color: var(--teal-bright); flex-shrink: 0; }
        .intern-end-date { color: var(--amber) !important; font-weight: 500; }
        .intern-end-date i { color: var(--amber) !important; }
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
        .empty-state i { font-size: 48px; opacity: 0.2; margin-bottom: 16px; display: block; color: var(--teal-bright); }
        .empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 6px; color: var(--text-main); }
        .empty-state p { font-size: 13px; }
        @media (max-width: 768px) { .staff-grid-v2 { grid-template-columns: 1fr; } .top-stats-row { grid-template-columns: 1fr 1fr; } }
    </style>
</head>
<body>
<div class="dashboard-layout">

    {{-- ══ SIDEBAR ══ --}}
    @include('components.sidebar2')

    <main class="dashboard-main">
        <div class="topbar">
            <div class="topbar-breadcrumb">
                <i class="fas fa-home"></i>
                <span style="opacity:.4;">›</span>
                <span>Team</span>
                <span style="opacity:.4;">›</span>
                <span class="current">Team Staff</span>
            </div>
        </div>

        <div class="page-content">
            <div class="page-header">
                <h2><i class="fas fa-sitemap" style="color:var(--teal-bright);margin-right:8px;"></i>Team Staff</h2>
                <p>Organization structure by teams and positions</p>
            </div>

            <div class="top-stats-row">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-info"><h3>Total Teams</h3><h2>{{ $totalTeams }}</h2></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-user-friends"></i></div>
                    <div class="stat-info"><h3>Total Staff</h3><h2>{{ $totalStaff }}</h2></div>
                </div>
            </div>

            @foreach($teams as $teamName => $teamData)
                @if($teamData['staff']->count() > 0)
                <div class="team-section">
                    <div class="team-header-v2" style="background-color: {{ $teamData['color'] }}">
                        <div class="team-title-section">
                            <i class="fas fa-users-cog"></i>
                            <div>
                                <h3>{{ $teamName }}</h3>
                                <span>{{ $teamData['staff']->count() }} {{ $teamData['staff']->count() == 1 ? 'Member' : 'Members' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="team-content-v2">
                        @php $currentPosition = ''; @endphp
                        @foreach($teamData['staff'] as $staff)
                            @if($currentPosition !== $staff->position)
                                @if($currentPosition !== '')
                                    </div></div>
                                @endif
                                <div class="position-section-v2">
                                    <div class="position-header-v2">
                                        <i class="fas fa-{{ strpos($staff->position, 'Lead') !== false || strpos($staff->position, 'Manager') !== false ? 'crown' : 'user-tie' }}"></i>
                                        <span>{{ $staff->position }}</span>
                                        @if(strpos($staff->position, 'Lead') !== false)
                                            <span class="hou-tag">HOU</span>
                                        @endif
                                    </div>
                                    <div class="staff-grid-v2">
                                @php $currentPosition = $staff->position; @endphp
                            @endif
                            <div class="staff-card-v2">
                                <div class="staff-avatar-v2" style="background-color: {{ $teamData['color'] }}">
                                    @if($staff->profile_photo && Storage::disk('public')->exists($staff->profile_photo))
                                        <img src="{{ asset('storage/' . $staff->profile_photo) }}" alt="{{ $staff->name }}">
                                    @else
                                        {{ strtoupper(substr($staff->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="staff-details-v2">
                                    <h4>{{ $staff->name }}</h4>
                                    <div class="staff-contact-v2">
                                        <span><i class="fas fa-envelope"></i> {{ $staff->email ?? 'N/A' }}</span>
                                        <span><i class="fas fa-phone"></i> {{ $staff->phone_number ?? 'N/A' }}</span>
                                        @if($staff->secondary_phone_number)
                                            <span><i class="fas fa-phone-alt"></i> {{ $staff->secondary_phone_number }}</span>
                                        @endif
                                        @if($staff->role === 'intern' && $staff->internship_end_date)
                                            <span class="intern-end-date">
                                                <i class="fas fa-calendar-times"></i>
                                                Ends: {{ \Carbon\Carbon::parse($staff->internship_end_date)->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div></div>
                    </div>
                </div>
                @endif
            @endforeach

            @if($totalStaff == 0)
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h3>No Staff Found</h3>
                <p>There are no active staff members in the system</p>
            </div>
            @endif
        </div>
    </main>
</div>
</body>
</html>
