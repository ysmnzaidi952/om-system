{{-- C:\laragon\www\om_system\resources\views\profile\show.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | O&M HRCare</title>
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
        .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 0 28px; height: 60px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb a { color: var(--text-muted); transition: color 0.2s; }
        .topbar-breadcrumb a:hover { color: var(--teal-bright); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }
        .page-content { padding: 24px 28px; flex: 1; }

        /* ══ ALERT ══ */
        .alert { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; font-weight: 500; }
        .alert-success { background: rgba(34,197,94,0.1); color: #15803d; border: 1px solid rgba(34,197,94,0.25); }

        /* ══ PROFILE HERO ══ */
        .profile-hero { background: var(--teal-base); border-radius: 12px; padding: 28px 32px; margin-bottom: 20px; display: flex; align-items: center; gap: 24px; color: #fff; box-shadow: var(--shadow-sm); }
        .profile-avatar { width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255,255,255,0.3); flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; color: #fff; background: rgba(255,255,255,0.15); }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-hero-info { flex: 1; min-width: 0; }
        .profile-hero-name { font-size: 22px; font-weight: 700; margin-bottom: 4px; letter-spacing: -0.3px; }
        .profile-hero-meta { font-size: 12px; opacity: 0.75; margin-bottom: 12px; display: flex; flex-wrap: wrap; gap: 14px; }
        .profile-hero-meta span { display: flex; align-items: center; gap: 5px; }
        .profile-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .badge { padding: 4px 12px; border-radius: 20px; background: rgba(255,255,255,0.15); font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 5px; border: 1px solid rgba(255,255,255,0.2); }
        .badge-active { background: rgba(34,197,94,0.25); border-color: rgba(34,197,94,0.4); }
        .badge-inactive { background: rgba(239,68,68,0.25); border-color: rgba(239,68,68,0.4); }
        .btn-edit { background: #fff; color: var(--teal-base); border: none; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); display: flex; align-items: center; gap: 7px; text-decoration: none; transition: all 0.2s; flex-shrink: 0; }
        .btn-edit:hover { background: var(--off-white); }

        /* ══ PROFILE CARDS ══ */
        .profile-card { background: #fff; border-radius: 10px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); margin-bottom: 16px; overflow: hidden; }
        .card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
        .card-header h4 { font-size: 13px; font-weight: 700; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .card-header i { color: var(--teal-bright); font-size: 13px; }
        .card-body { padding: 16px 20px; }

        /* ══ INFO GRID ══ */
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
        .info-row { padding: 10px 0; border-bottom: 1px solid var(--border); display: grid; grid-template-columns: 160px 1fr; gap: 12px; align-items: start; }
        .info-row:last-child { border-bottom: none; }
        .info-row.full-width { grid-column: 1 / -1; }
        .info-label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; padding-top: 1px; }
        .info-value { font-size: 13px; color: var(--text-main); font-weight: 500; }
        .info-value.not-set { color: var(--text-muted); font-style: italic; font-weight: 400; }

        /* ══ STATUS / ROLE BADGES ══ */
        .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .status-active   { background: rgba(34,197,94,0.1);  color: #15803d; }
        .status-inactive { background: rgba(239,68,68,0.1);  color: #dc2626; }
        .status-pending  { background: rgba(245,158,11,0.1); color: #92400e; }
        .role-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: rgba(14,165,160,0.1); color: var(--teal-base); }

        @media (max-width: 768px) {
            .profile-hero { flex-direction: column; text-align: center; }
            .profile-hero-meta { justify-content: center; }
            .info-grid { grid-template-columns: 1fr; }
            .info-row { grid-template-columns: 1fr; gap: 2px; }
        }
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
                <span class="current">My Profile</span>
            </div>
        </div>

        <div class="page-content">
            @if(session('success'))
            <div class="alert alert-success" id="alertSuccess">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            {{-- PROFILE HERO --}}
            <div class="profile-hero">
                <div class="profile-avatar">
                    @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                    @else
                        {{ $user->initials }}
                    @endif
                </div>
                <div class="profile-hero-info">
                    <div class="profile-hero-name">{{ $user->name }}</div>
                    <div class="profile-hero-meta">
                        {{-- ── UPDATED: ic → id_number + id_type ── --}}
                        <span>
                            <i class="fas fa-id-card"></i>
                            @if($user->id_type === 'passport')
                                {{ $user->id_number }}
                            @else
                                {{ substr($user->id_number, 0, 6) }}-{{ substr($user->id_number, 6, 2) }}-{{ substr($user->id_number, 8, 4) }}
                            @endif
                        </span>
                        <span><i class="fas fa-envelope"></i> {{ $user->email ?? 'Not set' }}</span>
                        <span><i class="fas fa-phone"></i> {{ $user->phone_number ?? 'Not set' }}</span>
                    </div>
                    <div class="profile-badges">
                        <span class="badge"><i class="fas fa-user-tag"></i> {{ ucfirst($user->role) }}</span>
                        <span class="badge"><i class="fas fa-briefcase"></i> {{ $user->position ?? 'No position' }}</span>
                        <span class="badge {{ $user->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                            <i class="fas fa-circle" style="font-size:7px;"></i> {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>

            {{-- BASIC INFORMATION --}}
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-id-card"></i>
                    <h4>Basic Information</h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        {{-- ── UPDATED: label & value guna id_number + id_type ── --}}
                        <div class="info-row">
                            <span class="info-label">{{ $user->id_type === 'passport' ? 'Passport No.' : 'IC Number' }}</span>
                            <span class="info-value">
                                @if($user->id_type === 'passport')
                                    {{ $user->id_number }}
                                @else
                                    {{ substr($user->id_number, 0, 6) }}-{{ substr($user->id_number, 6, 2) }}-{{ substr($user->id_number, 8, 4) }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Role</span>
                            <span class="info-value"><span class="role-badge">{{ ucfirst($user->role) }}</span></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Position</span>
                            <span class="info-value">{{ $user->position ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ $user->status }}">{{ ucfirst($user->status) }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INTERNSHIP PERIOD (INTERNS ONLY) --}}
            @if($user->role === 'intern')
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt"></i>
                    <h4>Internship Period</h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Start Date</span>
                            <span class="info-value">{{ $user->internship_start_date ? \Carbon\Carbon::parse($user->internship_start_date)->format('d M Y') : 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">End Date</span>
                            <span class="info-value">{{ $user->internship_end_date ? \Carbon\Carbon::parse($user->internship_end_date)->format('d M Y') : 'Not set' }}</span>
                        </div>
                        @if($user->internship_start_date && $user->internship_end_date)
                        <div class="info-row">
                            <span class="info-label">Total Duration</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($user->internship_start_date)->diffInDays(\Carbon\Carbon::parse($user->internship_end_date)) + 1 }} days</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                @php
                                    $today = \Carbon\Carbon::today();
                                    $start = \Carbon\Carbon::parse($user->internship_start_date);
                                    $end   = \Carbon\Carbon::parse($user->internship_end_date);
                                @endphp
                                @if($today->lt($start))
                                    <span class="status-badge status-pending">Not Started</span>
                                @elseif($today->between($start, $end))
                                    <span class="status-badge status-active">Active</span>
                                @else
                                    <span class="status-badge" style="background:rgba(100,116,139,0.1);color:#475569;">Completed</span>
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- CONTACT INFORMATION --}}
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-address-book"></i>
                    <h4>Contact Information</h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Phone Number</span>
                            <span class="info-value">{{ $user->phone_number ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Secondary Phone</span>
                            <span class="info-value">{{ $user->secondary_phone_number ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row full-width">
                            <span class="info-label">IC Address</span>
                            <span class="info-value">{{ $user->ic_address ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row full-width">
                            <span class="info-label">Current Address</span>
                            <span class="info-value">{{ $user->current_address ?? 'Not set' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PERSONAL INFORMATION --}}
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i>
                    <h4>Personal Information</h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Date of Birth</span>
                            <span class="info-value">
                                {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : 'Not set' }}
                                @if($user->date_of_birth)
                                    <span style="color:var(--text-muted);font-size:11px;"> ({{ \Carbon\Carbon::parse($user->date_of_birth)->age }} years old)</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date Joined</span>
                            <span class="info-value">{{ $user->date_joined ? \Carbon\Carbon::parse($user->date_joined)->format('d M Y') : 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date Confirmed</span>
                            <span class="info-value">{{ $user->date_confirmed ? \Carbon\Carbon::parse($user->date_confirmed)->format('d M Y') : 'Not confirmed yet' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Years of Experience</span>
                            <span class="info-value">{{ $user->years_of_experience ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Staff Status</span>
                            <span class="info-value">{{ $user->staff_status ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Shirt Size</span>
                            <span class="info-value">{{ $user->shirt_size ?? 'Not set' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PROFESSIONAL INFORMATION --}}
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-briefcase"></i>
                    <h4>Professional Information</h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-row full-width">
                            <span class="info-label">Academic Qualification</span>
                            <span class="info-value">{{ $user->academic_qualification ?? 'Not set' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FINANCIAL INFORMATION --}}
            <div class="profile-card">
                <div class="card-header">
                    <i class="fas fa-wallet"></i>
                    <h4>Financial Information</h4>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">EPF Number</span>
                            <span class="info-value">{{ $user->epf_number ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Bank Name</span>
                            <span class="info-value">{{ $user->bank_name ?? 'Not set' }}</span>
                        </div>
                        <div class="info-row full-width">
                            <span class="info-label">Bank Account Number</span>
                            <span class="info-value">{{ $user->bank_account_number ?? 'Not set' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.getElementById('alertSuccess');
    if (alert) setTimeout(() => { alert.style.transition='opacity 1s'; alert.style.opacity='0'; setTimeout(()=>alert.remove(),1000); }, 5000);
});
</script>
</body>
</html>
