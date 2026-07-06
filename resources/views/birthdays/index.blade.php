{{-- C:\laragon\www\om_system\resources\views\birthdays\index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Birthdays {{ $currentYear }} | O&M HRCare</title>
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
            --shadow-md:   0 8px 32px rgba(6,62,60,0.15);
            --font:        'Poppins', sans-serif;
            --red: #ef4444; --amber: #f59e0b; --green: #22c55e; --blue: #3b82f6;
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
        .page-header { margin-bottom: 20px; }
        .page-header h2 { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .page-header p { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ══ FILTER CARD ══ */
        .filter-card { background: #fff; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
        .filter-grid { display: grid; grid-template-columns: 1fr 1fr auto; gap: 12px; align-items: end; }
        .form-group label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 7px; font-family: var(--font); font-size: 13px; color: var(--text-main); background: var(--off-white); outline: none; transition: border 0.2s; }
        .form-control:focus { border-color: var(--teal-bright); background: #fff; box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        .filter-actions { display: flex; gap: 8px; align-items: center; }
        .btn { padding: 8px 16px; border-radius: 7px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; font-family: var(--font); transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
        .btn-primary { background: var(--teal-bright); color: #fff; }
        .btn-primary:hover { background: #0c9490; }
        .btn-ghost { background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: #e4f4f4; color: var(--text-main); }

        /* ══ MONTH SECTION ══ */
        .month-section { margin-bottom: 28px; }
        .month-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .month-label { font-size: 14px; font-weight: 700; color: var(--text-main); }
        .month-count { font-size: 11px; color: var(--text-muted); font-weight: 500; background: var(--off-white); padding: 2px 8px; border-radius: 10px; border: 1px solid var(--border); }

        /* ══ BIRTHDAY GRID ══ */
        .birthday-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 10px; }

        /* ══ BIRTHDAY CARD ══ */
        .birthday-card { padding: 14px 16px; border-radius: 9px; display: flex; align-items: center; gap: 12px; transition: all 0.2s; cursor: default; border-left: 3px solid transparent; background: #fff; border: 1px solid var(--border); border-left-width: 3px; }
        .birthday-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-sm); }
        .birthday-card.birthday-today { border-left-color: var(--amber) !important; background: #fffbeb; }
        .birthday-card.birthday-today .bday-icon { color: var(--amber); animation: pulse 2s infinite; }

        .month-1  { border-left-color: #1976d2; }
        .month-2  { border-left-color: #c2185b; }
        .month-3  { border-left-color: #7b1fa2; }
        .month-4  { border-left-color: #388e3c; }
        .month-5  { border-left-color: #f57c00; }
        .month-6  { border-left-color: var(--teal-bright); }
        .month-7  { border-left-color: #f39c12; }
        .month-8  { border-left-color: #512da8; }
        .month-9  { border-left-color: #0288d1; }
        .month-10 { border-left-color: #fbc02d; }
        .month-11 { border-left-color: #5d4037; }
        .month-12 { border-left-color: #d32f2f; }

        @keyframes pulse { 0%,100%{transform:scale(1);} 50%{transform:scale(1.15);} }

        /* ══ AVATAR ══ */
        .bday-photo { width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 700; color: #fff; overflow: hidden; }
        .bday-photo img { width: 100%; height: 100%; object-fit: cover; }

        /* ══ INFO ══ */
        .bday-info { flex: 1; min-width: 0; }
        .bday-name { font-size: 13px; font-weight: 600; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px; }
        .bday-position { font-size: 11px; color: var(--text-muted); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .bday-date { font-size: 12px; font-weight: 600; color: var(--teal-bright); display: flex; align-items: center; gap: 5px; }
        .today-tag { background: var(--amber); color: #fff; font-size: 10px; font-weight: 700; padding: 1px 7px; border-radius: 10px; margin-left: 4px; }

        /* ══ GIFT ICON ══ */
        .bday-icon { font-size: 20px; color: var(--teal-bright); flex-shrink: 0; opacity: 0.7; }

        /* ══ EMPTY STATE ══ */
        .empty-state { text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); }
        .empty-state i { font-size: 48px; opacity: 0.2; margin-bottom: 16px; display: block; color: var(--teal-bright); }
        .empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 6px; color: var(--text-main); }
        .empty-state p { font-size: 13px; color: var(--text-muted); }

        @media (max-width: 768px) { .filter-grid { grid-template-columns: 1fr; } .birthday-grid { grid-template-columns: 1fr; } }
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
                <span class="current">Staff Birthdays {{ $currentYear }}</span>
            </div>
        </div>

        <div class="page-content">
            <div class="page-header">
                <h2><i class="fas fa-gift" style="color:var(--teal-bright);margin-right:8px;"></i>Staff Birthdays {{ $currentYear }}</h2>
                <p>Celebrating our team members throughout the year</p>
            </div>

            {{-- FILTER --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('birthdays.index') }}" id="filterForm">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label><i class="fas fa-search" style="margin-right:4px;"></i>Search by Name</label>
                            <input type="text" name="search" class="form-control" placeholder="Enter staff name..." value="{{ $searchName }}">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar" style="margin-right:4px;"></i>Filter by Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value="all" {{ $selectedMonth === 'all' ? 'selected' : '' }}>All Months</option>
                                <option value="1"  {{ $selectedMonth == 1  ? 'selected' : '' }}>January</option>
                                <option value="2"  {{ $selectedMonth == 2  ? 'selected' : '' }}>February</option>
                                <option value="3"  {{ $selectedMonth == 3  ? 'selected' : '' }}>March</option>
                                <option value="4"  {{ $selectedMonth == 4  ? 'selected' : '' }}>April</option>
                                <option value="5"  {{ $selectedMonth == 5  ? 'selected' : '' }}>May</option>
                                <option value="6"  {{ $selectedMonth == 6  ? 'selected' : '' }}>June</option>
                                <option value="7"  {{ $selectedMonth == 7  ? 'selected' : '' }}>July</option>
                                <option value="8"  {{ $selectedMonth == 8  ? 'selected' : '' }}>August</option>
                                <option value="9"  {{ $selectedMonth == 9  ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $selectedMonth == 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ $selectedMonth == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $selectedMonth == 12 ? 'selected' : '' }}>December</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="opacity:0;">Action</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                                @if($selectedMonth !== 'all' || $searchName)
                                    <a href="{{ route('birthdays.index') }}" class="btn btn-ghost"><i class="fas fa-times"></i> Clear</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- BIRTHDAY LIST --}}
            @if(count($birthdaysByMonth) > 0)
                @foreach($birthdaysByMonth as $month => $birthdays)
                    @php
                        $monthNames = [
                            1=>'January',2=>'February',3=>'March',4=>'April',
                            5=>'May',6=>'June',7=>'July',8=>'August',
                            9=>'September',10=>'October',11=>'November',12=>'December'
                        ];
                    @endphp
                    <div class="month-section">
                        <div class="month-header">
                            <i class="fas fa-calendar-day" style="color:var(--teal-bright);font-size:13px;"></i>
                            <span class="month-label">{{ $monthNames[$month] }}</span>
                            <span class="month-count">{{ count($birthdays) }} {{ count($birthdays) === 1 ? 'birthday' : 'birthdays' }}</span>
                        </div>

                        <div class="birthday-grid">
                            @foreach($birthdays as $birthday)
                                <div class="birthday-card month-{{ $month }} {{ $birthday['is_today'] ? 'birthday-today' : '' }}">
                                    <div class="bday-photo" style="background: {{ $birthday['staff']->avatar_color }};">
                                        @if($birthday['staff']->profile_photo)
                                            <img src="{{ $birthday['staff']->profile_photo_url }}" alt="{{ $birthday['staff']->name }}">
                                        @else
                                            {{ $birthday['staff']->initials }}
                                        @endif
                                    </div>
                                    <div class="bday-info">
                                        <div class="bday-name">{{ $birthday['staff']->name }}</div>
                                        <div class="bday-position">{{ $birthday['staff']->position ?? 'N/A' }}</div>
                                        <div class="bday-date">
                                            <i class="fas fa-birthday-cake"></i>
                                            {{ $birthday['formatted_date'] }}
                                            @if($birthday['is_today'])
                                                <span class="today-tag">🎉 TODAY!</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="bday-icon"><i class="fas fa-gift"></i></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-gift"></i>
                    <h3>No Birthdays Found</h3>
                    <p>{{ $searchName ? 'No staff found matching "' . $searchName . '"' : 'No birthdays to display for the selected criteria.' }}</p>
                </div>
            @endif
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('month').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
</body>
</html>
