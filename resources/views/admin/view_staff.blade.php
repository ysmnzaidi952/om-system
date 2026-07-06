<!-- C:\laragon\www\om_system\resources\views\admin\view_staff.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff | O&M HRCare</title>
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
            padding: 0 28px; height: 60px; display: flex; align-items: center;
            position: sticky; top: 0; z-index: 40; box-shadow: 0 1px 8px rgba(0,0,0,0.04);
        }
        .topbar-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-muted); }
        .topbar-breadcrumb a { color: var(--text-muted); transition: color 0.2s; }
        .topbar-breadcrumb a:hover { color: var(--teal-bright); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }

        /* ── CONTENT ── */
        .page-content { padding: 24px 28px; flex: 1; }

        /* ── TWO COLUMN GRID FOR INFO CARDS ── */
        .info-grid-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; align-items: start; }
        .info-grid-layout .full-col { grid-column: 1 / -1; }

        /* ── ALERTS ── */
        .alert { display: flex; align-items: center; gap: 9px; padding: 11px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: rgba(34,197,94,0.08); color: #166534; border: 1px solid rgba(34,197,94,0.2); border-left: 3px solid var(--green); }

        /* ── PROFILE HEADER ── */
        .profile-header {
            background: var(--teal-base); border-radius: 12px;
            padding: 24px 28px; margin-bottom: 16px;
            display: flex; align-items: center; gap: 24px;
            box-shadow: var(--shadow-sm);
        }
        .profile-photo {
            width: 80px; height: 80px; border-radius: 50%; flex-shrink: 0;
            border: 3px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.15); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700; overflow: hidden;
        }
        .profile-photo img { width: 100%; height: 100%; object-fit: cover; }
        .profile-info { flex: 1; min-width: 0; }
        .profile-info h2 { font-size: 20px; font-weight: 700; color: #fff; margin: 0 0 4px; }
        .profile-info p  { font-size: 12px; color: rgba(255,255,255,0.75); margin: 2px 0; display: flex; align-items: center; gap: 7px; }
        .profile-info p i { width: 14px; flex-shrink: 0; }
        .profile-badges  { display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap; }
        .profile-badge   { padding: 4px 12px; border-radius: 20px; background: rgba(255,255,255,0.15); color: #fff; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 6px; }
        .profile-badge.active-badge { background: rgba(34,197,94,0.25); }
        .profile-edit-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; background: rgba(255,255,255,0.15); color: #fff;
            border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;
            font-family: var(--font); font-size: 12px; font-weight: 600;
            transition: all 0.2s; flex-shrink: 0; align-self: flex-start;
        }
        .profile-edit-btn:hover { background: rgba(255,255,255,0.25); color: #fff; }

        /* ── INFO CARD ── */
        .info-card { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: 14px; overflow: hidden; }
        .info-card-head { padding: 12px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; background: var(--off-white); }
        .info-card-head h4 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-main); margin: 0; }
        .info-card-head i  { color: var(--teal-bright); font-size: 12px; }
        .info-card-body { padding: 4px 0; }

        /* ── INFO ROWS ── */
        .info-row { display: flex; align-items: flex-start; padding: 10px 20px; border-bottom: 1px solid rgba(14,165,160,0.05); }
        .info-row:last-child { border-bottom: none; }
        .info-row:hover { background: #fafffe; }
        .info-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); width: 180px; flex-shrink: 0; padding-top: 1px; }
        .info-value { font-size: 13px; color: var(--text-main); flex: 1; }
        .info-value a { color: var(--teal-bright); display: inline-flex; align-items: center; gap: 5px; }
        .info-value a:hover { text-decoration: underline; }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; }
        .badge-admin      { background: rgba(139,92,246,0.1);  color: #5b21b6; }
        .badge-superadmin { background: rgba(239,68,68,0.1);   color: #991b1b; }
        .badge-staff      { background: rgba(14,165,160,0.1);  color: #0a5654; }
        .badge-intern     { background: rgba(59,130,246,0.1);  color: #1e40af; }
        .badge-part-time  { background: rgba(245,158,11,0.1);  color: #92400e; }
        .badge-staff-ge   { background: rgba(34,197,94,0.1);   color: #166534; }
        .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px; border-radius: 20px; font-size: 10px; font-weight: 700; }
        .status-active   { background: rgba(34,197,94,0.1);   color: #166534; }
        .status-pending  { background: rgba(245,158,11,0.1);  color: #92400e; }
        .status-inactive { background: rgba(107,114,128,0.1); color: #374151; }
        .status-cancelled { background: rgba(107,114,128,0.1); color: #374151; }
        .status-approved { background: rgba(34,197,94,0.1);   color: #166534; }

        /* ── WARN BOX ── */
        .warn-box { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.25); border-left: 3px solid var(--amber); border-radius: 8px; padding: 12px 14px; margin: 12px 20px; font-size: 12px; color: #92400e; }
        .warn-box i { color: var(--amber); margin-right: 4px; }
        .warn-box a { color: #92400e; text-decoration: underline; }

        /* ── ACTIONS ── */
        .page-actions { display: flex; gap: 10px; margin-top: 20px; }
        .btn-back { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); border-radius: 7px; font-family: var(--font); font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-back:hover { background: #e0f0f0; color: var(--text-main); }

        @media (max-width: 768px) { .profile-header { flex-direction: column; text-align: center; } .info-label { width: 130px; } .page-content { padding: 16px; } }
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
                <a href="{{ route('admin.all-staff') }}">All Staff</a>
                <span style="opacity:.4;">›</span>
                <span class="current">{{ $staff->name }}</span>
            </div>
        </div>

        <div class="page-content">

            @if(session('success'))
                <div class="alert alert-success" id="alertSuccess"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-photo">
                    @if($staff->profile_photo && Storage::disk('public')->exists($staff->profile_photo))
                        <img src="{{ asset('storage/' . $staff->profile_photo) }}" alt="{{ $staff->name }}">
                    @else
                        {{ $staff->initials }}
                    @endif
                </div>
                <div class="profile-info">
                    <h2>{{ $staff->name }}</h2>
                    {{-- ── UPDATED: ic → id_number + id_type ── --}}
                    <p>
                        <i class="fas fa-id-card"></i>
                        @if($staff->id_type === 'passport')
                            {{ $staff->id_number }}
                        @else
                            {{ substr($staff->id_number,0,6) }}-{{ substr($staff->id_number,6,2) }}-{{ substr($staff->id_number,8,4) }}
                        @endif
                    </p>
                    <p><i class="fas fa-envelope"></i> {{ $staff->email ?? 'Not set' }}</p>
                    <p><i class="fas fa-phone"></i> {{ $staff->phone_number ?? 'Not set' }}</p>
                    <div class="profile-badges">
                        <span class="profile-badge"><i class="fas fa-user-tag"></i> {{ ucfirst(str_replace('_',' ',$staff->role)) }}</span>
                        <span class="profile-badge"><i class="fas fa-briefcase"></i> {{ $staff->position ?? 'No position' }}</span>
                        <span class="profile-badge {{ $staff->status === 'active' ? 'active-badge' : '' }}">
                            <i class="fas fa-circle" style="font-size:6px;"></i> {{ ucfirst($staff->status) }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.edit-staff', $staff->id) }}" class="profile-edit-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>

            {{-- ── 2-COLUMN GRID START ── --}}
            <div class="info-grid-layout">

                {{-- LEFT: Basic Information --}}
                <div class="info-card">
                    <div class="info-card-head"><i class="fas fa-id-card"></i><h4>Basic Information</h4></div>
                    <div class="info-card-body">
                        <div class="info-row"><span class="info-label">Staff ID</span><span class="info-value"><strong>#{{ $staff->id }}</strong></span></div>
                        <div class="info-row"><span class="info-label">Full Name</span><span class="info-value">{{ $staff->name }}</span></div>
                        {{-- ── UPDATED: ic → id_number + id_type, label dynamic ── --}}
                        <div class="info-row">
                            <span class="info-label">{{ $staff->id_type === 'passport' ? 'Passport No.' : 'IC Number' }}</span>
                            <span class="info-value">
                                @if($staff->id_type === 'passport')
                                    {{ $staff->id_number }}
                                @else
                                    {{ substr($staff->id_number,0,6) }}-{{ substr($staff->id_number,6,2) }}-{{ substr($staff->id_number,8,4) }}
                                @endif
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">Email</span><span class="info-value">@if($staff->email)<a href="mailto:{{ $staff->email }}"><i class="fas fa-envelope"></i> {{ $staff->email }}</a>@else Not provided @endif</span></div>
                        <div class="info-row">
                            <span class="info-label">Role</span>
                            <span class="info-value">
                                <span class="badge badge-{{ strtolower(str_replace('_','-',$staff->role)) }}">
                                    <i class="fas {{ in_array($staff->role,['admin','superadmin']) ? 'fa-user-shield' : 'fa-user' }}"></i>
                                    {{ ucfirst(str_replace('_',' ',$staff->role)) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ $staff->status }}">
                                    <i class="fas {{ $staff->status == 'active' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ ucfirst($staff->status) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">Staff Status</span><span class="info-value">{{ $staff->staff_status ?? 'Not specified' }}</span></div>
                        <div class="info-row"><span class="info-label">Shirt Size</span><span class="info-value">{{ $staff->shirt_size ?? 'Not specified' }}</span></div>
                    </div>
                </div>

                {{-- RIGHT: Contact Information --}}
                <div class="info-card">
                    <div class="info-card-head"><i class="fas fa-address-book"></i><h4>Contact Information</h4></div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <span class="info-label">Phone Number</span>
                            <span class="info-value">
                                @if($staff->phone_number)
                                    @php $p = $staff->phone_number; if(substr($p,0,2)=='60') $p=substr($p,2); $fmt = substr($p,0,2)=='11' ? '+60 11-'.substr($p,2,4).' '.substr($p,6,4) : '+60 '.substr($p,0,2).'-'.substr($p,2,3).' '.substr($p,5,4); @endphp
                                    <a href="tel:+60{{ $p }}"><i class="fas fa-phone"></i> {{ $fmt }}</a>
                                @else Not provided @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Secondary Phone</span>
                            <span class="info-value">
                                @if($staff->secondary_phone_number)
                                    @php $p2=$staff->secondary_phone_number; if(substr($p2,0,2)=='60') $p2=substr($p2,2); $fmt2=substr($p2,0,2)=='11' ? '+60 11-'.substr($p2,2,4).' '.substr($p2,6,4) : '+60 '.substr($p2,0,2).'-'.substr($p2,2,3).' '.substr($p2,5,4); @endphp
                                    <a href="tel:+60{{ $p2 }}"><i class="fas fa-phone"></i> {{ $fmt2 }}</a>
                                @else Not provided @endif
                            </span>
                        </div>
                        <div class="info-row"><span class="info-label">IC Address</span><span class="info-value" style="white-space:pre-wrap;">{{ $staff->ic_address ?? 'Not provided' }}</span></div>
                        <div class="info-row"><span class="info-label">Current Address</span><span class="info-value" style="white-space:pre-wrap;">{{ $staff->current_address ?? 'Not provided' }}</span></div>
                    </div>
                </div>

                {{-- LEFT: Personal Information --}}
                <div class="info-card">
                    <div class="info-card-head"><i class="fas fa-user-circle"></i><h4>Personal Information</h4></div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <span class="info-label">Date of Birth</span>
                            <span class="info-value">@if($staff->date_of_birth){{ \Carbon\Carbon::parse($staff->date_of_birth)->format('d M Y') }} <span style="color:var(--text-muted);font-size:11px;">({{ \Carbon\Carbon::parse($staff->date_of_birth)->age }} years old)</span>@else Not provided @endif</span>
                        </div>
                        <div class="info-row"><span class="info-label">Date Joined</span><span class="info-value">{{ $staff->date_joined ? \Carbon\Carbon::parse($staff->date_joined)->format('d M Y') : 'Not specified' }}</span></div>
                        <div class="info-row"><span class="info-label">Date Confirmed</span><span class="info-value">{{ $staff->date_confirmed ? \Carbon\Carbon::parse($staff->date_confirmed)->format('d M Y') : 'Not confirmed' }}</span></div>
                        <div class="info-row"><span class="info-label">Experience</span><span class="info-value">{{ $staff->years_of_experience ?? 'Not specified' }}</span></div>
                        <div class="info-row"><span class="info-label">Registered</span><span class="info-value">{{ $staff->created_at->format('d M Y') }}</span></div>
                    </div>
                </div>

                {{-- RIGHT: Professional + Financial --}}
                <div style="display:flex; flex-direction:column; gap:14px;">
                    <div class="info-card">
                        <div class="info-card-head"><i class="fas fa-briefcase"></i><h4>Professional Information</h4></div>
                        <div class="info-card-body">
                            <div class="info-row"><span class="info-label">Position</span><span class="info-value">{{ $staff->position ?? 'Not specified' }}</span></div>
                            <div class="info-row"><span class="info-label">Qualification</span><span class="info-value" style="white-space:pre-wrap;">{{ $staff->academic_qualification ?? 'Not provided' }}</span></div>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-head"><i class="fas fa-wallet"></i><h4>Financial Information</h4></div>
                        <div class="info-card-body">
                            <div class="info-row"><span class="info-label">EPF Number</span><span class="info-value">{{ $staff->epf_number ?? 'Not provided' }}</span></div>
                            <div class="info-row"><span class="info-label">Bank Name</span><span class="info-value">{{ $staff->bank_name ?? 'Not provided' }}</span></div>
                            <div class="info-row"><span class="info-label">Account Number</span><span class="info-value">{{ $staff->bank_account_number ?? 'Not provided' }}</span></div>
                        </div>
                    </div>
                </div>

                {{-- FULL WIDTH: Internship Period (Interns only) --}}
                @if($staff->role === 'intern')
                <div class="info-card full-col">
                    <div class="info-card-head"><i class="fas fa-calendar-alt"></i><h4>Internship Period</h4></div>
                    <div class="info-card-body">
                        <div style="display:grid; grid-template-columns: 1fr 1fr 1fr 1fr;">
                            <div class="info-row"><span class="info-label">Start Date</span><span class="info-value">{{ $staff->internship_start_date ? \Carbon\Carbon::parse($staff->internship_start_date)->format('d M Y') : 'Not set' }}</span></div>
                            <div class="info-row"><span class="info-label">End Date</span><span class="info-value">{{ $staff->internship_end_date ? \Carbon\Carbon::parse($staff->internship_end_date)->format('d M Y') : 'Not set' }}</span></div>
                            @if($staff->internship_start_date && $staff->internship_end_date)
                            <div class="info-row"><span class="info-label">Total Duration</span><span class="info-value">{{ \Carbon\Carbon::parse($staff->internship_start_date)->diffInDays(\Carbon\Carbon::parse($staff->internship_end_date)) + 1 }} days</span></div>
                            <div class="info-row">
                                <span class="info-label">Internship Status</span>
                                <span class="info-value">
                                    @php $today = \Carbon\Carbon::today(); $start = \Carbon\Carbon::parse($staff->internship_start_date); $end = \Carbon\Carbon::parse($staff->internship_end_date); @endphp
                                    @if($today->lt($start)) <span class="status-badge status-pending">Not Started</span>
                                    @elseif($today->between($start,$end)) <span class="status-badge status-approved">Active</span>
                                    @else <span class="status-badge status-cancelled">Completed</span>
                                    @endif
                                </span>
                            </div>
                            @endif
                        </div>
                        @if(!$staff->internship_start_date || !$staff->internship_end_date)
                            <div class="warn-box">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Internship dates not set.</strong> This intern cannot apply for leave until dates are configured.
                                <a href="{{ route('admin.edit-staff', $staff->id) }}">Edit profile</a> to set dates.
                            </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>
            {{-- ── 2-COLUMN GRID END ── --}}

            <div class="page-actions">
                <a href="{{ route('admin.all-staff') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Staff List</a>
            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('alertSuccess');
    if (el) setTimeout(() => { el.style.transition='opacity 1s'; el.style.opacity='0'; setTimeout(()=>el.remove(),1000); }, 5000);
});
</script>
</body>
</html>
