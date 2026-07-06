{{-- C:\laragon\www\om_system\resources\views\profile\edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | O&M HRCare</title>
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
        .topbar-breadcrumb a { color: var(--text-muted); transition: color 0.2s; }
        .topbar-breadcrumb a:hover { color: var(--teal-bright); }
        .topbar-breadcrumb .current { color: var(--text-main); font-weight: 500; }
        .page-content { padding: 24px 28px; flex: 1; }

        /* ══ ALERTS ══ */
        .alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: rgba(34,197,94,0.1); color: #15803d; border: 1px solid rgba(34,197,94,0.25); }
        .alert-error   { background: rgba(239,68,68,0.1);  color: #dc2626; border: 1px solid rgba(239,68,68,0.25); }
        .alert ul { margin: 4px 0 0 16px; padding: 0; }

        /* ══ FORM CARD ══ */
        .form-card { background: #fff; border-radius: 10px; box-shadow: var(--shadow-sm); border: 1px solid var(--border); margin-bottom: 16px; overflow: hidden; }
        .form-card-header { padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
        .form-card-header h4 { font-size: 12px; font-weight: 700; color: var(--text-main); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-card-header i { color: var(--teal-bright); font-size: 13px; }
        .form-card-body { padding: 20px; }

        /* ══ PHOTO SECTION ══ */
        .photo-section { display: flex; align-items: center; gap: 20px; padding: 16px; background: var(--off-white); border-radius: 8px; margin-bottom: 0; }
        .photo-circle { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 3px solid var(--border); flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; color: #fff; }
        .photo-circle img { width: 100%; height: 100%; object-fit: cover; }
        .photo-controls h4 { font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 4px; }
        .photo-controls p { font-size: 11px; color: var(--text-muted); margin-bottom: 10px; }
        .photo-btn-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-upload-label { position: relative; overflow: hidden; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 7px; background: var(--teal-bright); color: #fff; font-size: 12px; font-weight: 600; font-family: var(--font); transition: background 0.2s; }
        .btn-upload-label:hover { background: #0c9490; }
        .btn-upload-label input[type="file"] { position: absolute; left: -9999px; }
        .btn-danger { padding: 8px 14px; border-radius: 7px; background: rgba(239,68,68,0.1); color: var(--red); border: 1px solid rgba(239,68,68,0.2); font-size: 12px; font-weight: 600; cursor: pointer; font-family: var(--font); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-danger:hover { background: var(--red); color: #fff; }
        .new-photo-preview { margin-top: 12px; padding: 12px; background: #fff; border-radius: 7px; border: 1px dashed var(--teal-bright); display: none; }
        .new-photo-preview p { font-size: 11px; color: var(--teal-bright); font-weight: 600; margin-bottom: 8px; }
        .new-photo-preview img { max-width: 120px; max-height: 120px; border-radius: 7px; }

        /* ══ FORM ELEMENTS ══ */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; }
        .form-group label i { margin-right: 4px; }
        .form-control { width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 7px; font-family: var(--font); font-size: 13px; color: var(--text-main); background: #fff; outline: none; transition: border 0.2s; }
        .form-control:focus { border-color: var(--teal-bright); box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        .form-control[readonly], .form-control:disabled { background: #f5f5f5; color: var(--text-muted); cursor: not-allowed; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }
        .required { color: var(--red); }

        /* ══ WARNING BOX ══ */
        .warn-box { background: #fffbeb; border: 1px solid var(--amber); padding: 12px 14px; border-radius: 7px; font-size: 12px; color: #92400e; display: flex; gap: 8px; }
        .warn-box i { flex-shrink: 0; margin-top: 1px; }

        /* ══ ACTION BUTTONS ══ */
        .form-actions { display: flex; gap: 10px; padding: 20px 0 0; }
        .btn-primary { background: var(--teal-bright); color: #fff; border: none; padding: 10px 22px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); display: inline-flex; align-items: center; gap: 7px; transition: background 0.2s; text-decoration: none; }
        .btn-primary:hover { background: #0c9490; }
        .btn-secondary { background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); padding: 10px 22px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: var(--font); display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s; text-decoration: none; }
        .btn-secondary:hover { background: #e4f4f4; color: var(--text-main); }

        @media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } }
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
                <a href="{{ route('profile.show') }}">My Profile</a>
                <span style="opacity:.4;">›</span>
                <span class="current">Edit</span>
            </div>
        </div>

        <div class="page-content">

            @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                {{-- PROFILE PHOTO --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-camera"></i><h4>Profile Photo</h4></div>
                    <div class="form-card-body">
                        <div class="photo-section">
                            <div class="photo-circle" id="photoPreview" style="background: var(--teal-base);">
                                @if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo))
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo">
                                @else
                                    {{ $user->initials }}
                                @endif
                            </div>
                            <div class="photo-controls">
                                <h4>Update your photo</h4>
                                <p>JPG or PNG, max 2MB. Will be resized to 600×600px.</p>
                                <div class="photo-btn-row">
                                    <label for="profile_photo" class="btn-upload-label">
                                        <i class="fas fa-upload"></i> Choose Photo
                                        <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                    @if($user->profile_photo)
                                    <button type="button" class="btn-danger" onclick="if(confirm('Remove profile photo?')) { document.getElementById('deletePhotoForm').submit(); }">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                    @endif
                                </div>
                                <div id="newPhotoPreview" class="new-photo-preview">
                                    <p><i class="fas fa-image"></i> New photo preview:</p>
                                    <img id="newPhotoImg" src="" alt="Preview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BASIC INFORMATION --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-id-card"></i><h4>Basic Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            {{-- ── UPDATED: label & value guna id_number + id_type ── --}}
                            <div class="form-group">
                                <label><i class="fas fa-id-card-alt"></i> {{ $user->id_type === 'passport' ? 'Passport Number' : 'IC Number' }}</label>
                                <input type="text" class="form-control"
                                    value="{{ $user->id_type === 'passport'
                                        ? $user->id_number
                                        : substr($user->id_number, 0, 6).'-'.substr($user->id_number, 6, 2).'-'.substr($user->id_number, 8, 4) }}"
                                    readonly>
                                <div class="form-hint">{{ $user->id_type === 'passport' ? 'Passport Number — cannot be changed here' : 'IC Number — cannot be changed' }}</div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-briefcase"></i> Position</label>
                                <select class="form-control" id="position" name="position">
                                    <option value="">Select Position</option>
                                    @foreach([
                                        'Project/Operation Manager', 'Assistant Operation Manager',
                                        'Lead Customer Support Engineer', 'Customer Support Engineer',
                                        'Lead Application Support Engineer', 'Application Support Engineer',
                                        'Lead Network & Security Support Engineer', 'Network & Security Support Engineer',
                                        'Lead Technical Support Engineer', 'Technical Support Engineer',
                                        'Lead System Support Engineer', 'System Support Engineer',
                                        'Database Administrator', 'Part Timer', 'GE Support'
                                    ] as $pos)
                                        <option value="{{ $pos }}" {{ old('position', $user->position) == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-shield-alt"></i> Role</label>
                                @php $authRole = Auth::user()->role; $userRole = $user->role; @endphp
                                @if(in_array($authRole, ['superadmin', 'admin']))
                                    @if($authRole === 'superadmin')
                                        <select class="form-control" id="role" name="role">
                                            <option value="intern"     {{ $userRole === 'intern'     ? 'selected' : '' }}>Intern</option>
                                            <option value="staff"      {{ $userRole === 'staff'      ? 'selected' : '' }}>Staff</option>
                                            <option value="admin"      {{ $userRole === 'admin'      ? 'selected' : '' }}>Admin</option>
                                            <option value="superadmin" {{ $userRole === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                            <option value="part_time"  {{ $userRole === 'part_time'  ? 'selected' : '' }}>Part Time</option>
                                            <option value="staff_ge"   {{ $userRole === 'staff_ge'   ? 'selected' : '' }}>Staff GE (Support Engineer)</option>
                                        </select>
                                    @else
                                        <select class="form-control" id="role" name="role">
                                            <option value="intern"    {{ $userRole === 'intern'    ? 'selected' : '' }}>Intern</option>
                                            <option value="staff"     {{ $userRole === 'staff'     ? 'selected' : '' }}>Staff</option>
                                            <option value="admin"     {{ $userRole === 'admin'     ? 'selected' : '' }}>Admin</option>
                                            <option value="part_time" {{ $userRole === 'part_time' ? 'selected' : '' }}>Part Time</option>
                                            <option value="staff_ge"  {{ $userRole === 'staff_ge'  ? 'selected' : '' }}>Staff GE (Support Engineer)</option>
                                        </select>
                                    @endif
                                @else
                                    @php $roleLabels = ['staff'=>'Staff','intern'=>'Intern','part_time'=>'Part Time','staff_ge'=>'Staff GE (Support Engineer)','admin'=>'Admin','superadmin'=>'Superadmin']; @endphp
                                    <input type="text" class="form-control" value="{{ $roleLabels[$userRole] ?? $userRole }}" readonly>
                                    <div class="form-hint">Contact Admin to change your role</div>
                                @endif
                            </div>
                            <div class="form-group" id="roleChangeWarning" style="display:none;">
                                <label style="opacity:0;">Warning</label>
                                <div class="warn-box">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div><strong>Internship Data Will Be Cleared.</strong> Changing role from Intern to Staff/Admin will permanently delete internship dates and intern leave entitlements.</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-user-tag"></i> Staff Status</label>
                                <input type="text" class="form-control" value="{{ $user->staff_status ?? 'Not set' }}" readonly>
                                <div class="form-hint">Contact admin to change staff status</div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-tshirt"></i> Shirt Size</label>
                                <select class="form-control" id="shirt_size" name="shirt_size">
                                    <option value="">Select Size</option>
                                    @foreach(['XS','S','M','L','XL','2XL','3XL'] as $size)
                                        <option value="{{ $size }}" {{ old('shirt_size', $user->shirt_size) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CONTACT INFORMATION --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-address-book"></i><h4>Contact Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="text" class="form-control" id="phone_number_display" data-format="phone" data-hidden-input="phone_number" maxlength="17" placeholder="+60 XX-XXX XXXX" value="{{ old('phone_number', $user->phone_number) }}">
                                <input type="hidden" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-phone-alt"></i> Secondary Phone</label>
                                <input type="text" class="form-control" id="secondary_phone_number_display" data-format="phone" data-hidden-input="secondary_phone_number" maxlength="17" placeholder="+60 XX-XXX XXXX" value="{{ old('secondary_phone_number', $user->secondary_phone_number) }}">
                                <input type="hidden" id="secondary_phone_number" name="secondary_phone_number" value="{{ old('secondary_phone_number', $user->secondary_phone_number) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PERSONAL INFORMATION --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-user-circle"></i><h4>Personal Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                                {{-- ── UPDATED: untuk passport, DOB mungkin null, handle gracefully ── --}}
                                <input type="text" class="form-control"
                                    value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y') : ($user->id_type === 'passport' ? 'Not available (Passport user)' : 'Auto-calculated from IC') }}"
                                    readonly>
                                <div class="form-hint">
                                    @if($user->id_type === 'passport')
                                        Passport users — DOB not auto-extracted
                                    @else
                                        Auto-calculated from IC Number@if($user->date_of_birth) · Age: {{ \Carbon\Carbon::parse($user->date_of_birth)->age }} years old@endif
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-calendar-check"></i> Date Joined</label>
                                <input type="date" class="form-control" id="date_joined" name="date_joined" value="{{ old('date_joined', $user->date_joined ? \Carbon\Carbon::parse($user->date_joined)->format('Y-m-d') : '') }}">
                                <div class="form-hint">When you started working here</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-check"></i> Date Confirmed</label>
                                <input type="text" class="form-control" value="{{ $user->date_confirmed ? \Carbon\Carbon::parse($user->date_confirmed)->format('d/m/Y') : 'Not confirmed yet' }}" readonly>
                                <div class="form-hint">Contact admin to update</div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-chart-line"></i> Years of Experience</label>
                                <input type="text" class="form-control" id="years_of_experience" name="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}" readonly>
                                <div class="form-hint">Auto-calculated from Date Joined</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-map-marker-alt"></i> IC Address</label>
                            <textarea class="form-control" id="ic_address" name="ic_address" rows="3">{{ old('ic_address', $user->ic_address) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-home"></i> Current Address</label>
                            <textarea class="form-control" id="current_address" name="current_address" rows="3">{{ old('current_address', $user->current_address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- INTERNSHIP PERIOD (INTERNS ONLY) --}}
                @if(Auth::user()->role === 'intern')
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-calendar-alt"></i><h4>Internship Period</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-day"></i> Start Date <span class="required">*</span></label>
                                <input type="date" class="form-control" id="internship_start_date" name="internship_start_date" value="{{ old('internship_start_date', $user->internship_start_date) }}" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-calendar-check"></i> End Date <span class="required">*</span></label>
                                <input type="date" class="form-control" id="internship_end_date" name="internship_end_date" value="{{ old('internship_end_date', $user->internship_end_date) }}" required>
                            </div>
                        </div>
                        @if(!$user->internship_start_date || !$user->internship_end_date)
                        <div class="warn-box">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div><strong>Important:</strong> You must set your internship dates before applying for leave. Your entitlement is 5 AL + 5 MC for the entire internship period.</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- PROFESSIONAL INFORMATION --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-briefcase"></i><h4>Professional Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label><i class="fas fa-graduation-cap"></i> Academic Qualification</label>
                            <textarea class="form-control" id="academic_qualification" name="academic_qualification" rows="3">{{ old('academic_qualification', $user->academic_qualification) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- FINANCIAL INFORMATION --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-wallet"></i><h4>Financial Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label><i class="fas fa-id-badge"></i> EPF Number</label>
                            <input type="text" class="form-control" id="epf_number" name="epf_number" value="{{ old('epf_number', $user->epf_number) }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-university"></i> Bank Name</label>
                                <select class="form-control" id="bank_name" name="bank_name">
                                    <option value="">Select Bank</option>
                                    @foreach(['Maybank','CIMB','Public Bank','RHB','Hong Leong Bank','AmBank','Bank Islam','BSN','Bank Rakyat','Affin Bank','Alliance Bank','OCBC','UOB','HSBC','Standard Chartered'] as $bank)
                                        <option value="{{ $bank }}" {{ old('bank_name', $user->bank_name) == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-credit-card"></i> Bank Account Number</label>
                                <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $user->bank_account_number) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHANGE PASSWORD --}}
                <div class="form-card">
                    <div class="form-card-header"><i class="fas fa-lock"></i><h4>Change Password (Optional)</h4></div>
                    <div class="form-card-body">
                        <div class="form-hint" style="margin-bottom:14px;">Leave blank if you don't want to change your password.</div>
                        <div class="form-group">
                            <label><i class="fas fa-key"></i> Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-lock"></i> New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-lock"></i> Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="form-actions">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Update Profile</button>
                    <a href="{{ route('profile.show') }}" class="btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                </div>

            </form>
        </div>
    </main>
</div>

{{-- DELETE PHOTO FORM (outside main form) --}}
@if($user->profile_photo)
<form id="deletePhotoForm" action="{{ route('profile.delete-photo') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endif

<script src="{{ asset('js/formatters.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Years of experience auto-calculate
    const dateJoinedInput = document.getElementById('date_joined');
    const yearsInput      = document.getElementById('years_of_experience');

    function calcYears() {
        const val = dateJoinedInput.value;
        if (!val) { yearsInput.value = ''; return; }
        const joined = new Date(val), today = new Date();
        let years  = today.getFullYear() - joined.getFullYear();
        let months = today.getMonth()    - joined.getMonth();
        if (months < 0 || (months === 0 && today.getDate() < joined.getDate())) { years--; months += 12; }
        if (today.getDate() < joined.getDate()) months--;
        if (years === 0)       yearsInput.value = months + ' month' + (months !== 1 ? 's' : '');
        else if (months === 0) yearsInput.value = years  + ' year'  + (years  !== 1 ? 's' : '');
        else                   yearsInput.value = years  + ' year'  + (years  !== 1 ? 's' : '') + ', ' + months + ' month' + (months !== 1 ? 's' : '');
    }
    calcYears();
    dateJoinedInput.addEventListener('change', calcYears);

    // Photo preview
    const photoInput = document.getElementById('profile_photo');
    const previewBox = document.getElementById('newPhotoPreview');
    const previewImg = document.getElementById('newPhotoImg');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) { previewBox.style.display = 'none'; return; }
        if (!['image/jpeg','image/png','image/jpg'].includes(file.type)) {
            alert('Please upload a JPG or PNG image only.');
            photoInput.value = ''; return;
        }
        if (file.size > 2048 * 1024) {
            alert('File size must not exceed 2MB.');
            photoInput.value = ''; return;
        }
        const reader = new FileReader();
        reader.onload = e => { previewImg.src = e.target.result; previewBox.style.display = 'block'; };
        reader.readAsDataURL(file);
    });

    // Role change warning
    const roleSelect = document.getElementById('role');
    const warning    = document.getElementById('roleChangeWarning');
    const origRole   = '{{ $user->role }}';
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            warning.style.display = (origRole === 'intern' && ['staff','admin','superadmin'].includes(this.value)) ? 'block' : 'none';
        });
    }
});
</script>
</body>
</html>
