<!-- C:\laragon\www\om_system\resources\views\admin\edit_staff.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff | O&M HRCare</title>
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
        .page-header  { margin-bottom: 20px; }
        .page-header h2 { font-size: 20px; font-weight: 600; color: var(--text-main); letter-spacing: -0.3px; }
        .page-header p  { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

        /* ── ALERTS ── */
        .alert { display: flex; align-items: flex-start; gap: 9px; padding: 11px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: rgba(34,197,94,0.08);  color: #166534; border: 1px solid rgba(34,197,94,0.2);  border-left: 3px solid var(--green); }
        .alert-error   { background: rgba(239,68,68,0.08);  color: #dc2626; border: 1px solid rgba(239,68,68,0.2);  border-left: 3px solid var(--red); }
        .alert-error ul { margin: 4px 0 0 16px; padding: 0; }

        /* ── FORM CARD ── */
        .form-card { background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: 16px; overflow: hidden; }
        .form-card-head { padding: 13px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; background: var(--off-white); }
        .form-card-head h4 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-main); margin: 0; }
        .form-card-head i  { color: var(--teal-bright); font-size: 12px; }
        .form-card-body { padding: 20px; }

        /* ── FORM GRID ── */
        .form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .form-group { margin-bottom: 0; }
        .form-group label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 0.7px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; }
        .form-group label i { margin-right: 3px; }
        .required { color: var(--red); }
        .lv-input {
            width: 100%; padding: 9px 11px; border: 1px solid rgba(14,165,160,0.2); border-radius: 7px;
            font-family: var(--font); font-size: 13px; color: var(--text-main); background: #fff; outline: none;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .lv-input:focus { border-color: var(--teal-bright); box-shadow: 0 0 0 3px rgba(14,165,160,0.1); }
        .lv-input[readonly], .lv-input:disabled { background: #f5f5f5; color: var(--text-muted); cursor: not-allowed; }
        .lv-input.lv-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%230EA5A0' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 11px center; padding-right: 32px; cursor: pointer;
        }
        textarea.lv-input { resize: vertical; min-height: 80px; }
        .form-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

        /* ── WARN BOX ── */
        .warn-box { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.25); border-left: 3px solid var(--amber); border-radius: 8px; padding: 12px 14px; margin-top: 12px; font-size: 12px; color: #92400e; }
        .warn-box i { color: var(--amber); margin-right: 4px; }
        .warn-box p { margin: 5px 0 0; font-size: 11px; }

        /* ── ACTION ROW ── */
        .form-actions { display: flex; gap: 10px; padding-top: 4px; }
        .btn-submit { background: var(--teal-bright); color: #fff; border: none; padding: 10px 22px; border-radius: 7px; font-family: var(--font); font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background 0.2s; }
        .btn-submit:hover { background: #0c9490; }
        .btn-cancel { background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border); padding: 10px 22px; border-radius: 7px; font-family: var(--font); font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s; text-decoration: none; }
        .btn-cancel:hover { background: #e0f0f0; color: var(--text-main); }

        @media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } .page-content { padding: 16px; } }
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
                <a href="{{ route('admin.view-staff', $staff->id) }}">{{ $staff->name }}</a>
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
                    <i class="fas fa-exclamation-triangle" style="flex-shrink:0;"></i>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="page-header">
                <h2><i class="fas fa-user-edit" style="color:var(--teal-bright);margin-right:8px;"></i>Update Staff Details</h2>
                <p>Editing profile for <strong>{{ $staff->name }}</strong></p>
            </div>

            <form action="{{ route('admin.update-staff', $staff->id) }}" method="POST">
                @csrf

                {{-- ── BASIC INFORMATION ── --}}
                <div class="form-card">
                    <div class="form-card-head"><i class="fas fa-id-card"></i><h4>Basic Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-id-card-alt"></i>
                                    {{ $staff->id_type === 'passport' ? 'Passport Number' : 'IC Number' }}
                                </label>
                                <input type="text" class="lv-input"
                                    value="{{ $staff->id_type === 'ic'
                                        ? substr($staff->id_number,0,6).'-'.substr($staff->id_number,6,2).'-'.substr($staff->id_number,8,4)
                                        : $staff->id_number }}"
                                    readonly>
                                <div class="form-hint">
                                    {{ $staff->id_type === 'passport' ? 'Passport Number — cannot be changed here' : 'IC Number — cannot be changed' }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Full Name <span class="required">*</span></label>
                                <input type="text" class="lv-input" id="name" name="name" value="{{ old('name', $staff->name) }}" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" class="lv-input" id="email" name="email" value="{{ old('email', $staff->email) }}">
                            </div>
                            <div class="form-group">
                                <label for="position"><i class="fas fa-briefcase"></i> Position</label>
                                <select class="lv-input lv-select" id="position" name="position">
                                    <option value="">Select Position</option>
                                    @php
                                        $positions = [
                                            'Project/Operation Manager','Assistant Operation Manager',
                                            'Lead Customer Support Engineer','Customer Support Engineer',
                                            'Lead Application Support Engineer','Application Support Engineer',
                                            'Lead Network & Security Support Engineer','Network & Security Support Engineer',
                                            'Lead Technical Support Engineer','Technical Support Engineer',
                                            'Lead System Support Engineer','System Support Engineer',
                                            'Database Administrator','Intern','Part Timer','GE Support',
                                        ];
                                    @endphp
                                    @foreach($positions as $pos)
                                        <option value="{{ $pos }}" {{ old('position',$staff->position)==$pos?'selected':'' }}>{{ $pos }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="role"><i class="fas fa-shield-alt"></i> Role</label>
                                @php $authRole = Auth::user()->role; $staffRole = old('role', $staff->role); @endphp
                                @if($authRole === 'superadmin')
                                    <select class="lv-input lv-select" id="role" name="role">
                                        <option value="intern"     {{ $staffRole==='intern'     ?'selected':'' }}>Intern</option>
                                        <option value="staff"      {{ $staffRole==='staff'      ?'selected':'' }}>Staff</option>
                                        <option value="admin"      {{ $staffRole==='admin'      ?'selected':'' }}>Admin</option>
                                        <option value="superadmin" {{ $staffRole==='superadmin' ?'selected':'' }}>Superadmin</option>
                                        <option value="part_time"  {{ $staffRole==='part_time'  ?'selected':'' }}>Part Time</option>
                                        <option value="staff_ge"   {{ $staffRole==='staff_ge'   ?'selected':'' }}>Staff GE (Support Engineer)</option>
                                    </select>
                                @else
                                    <select class="lv-input lv-select" id="role" name="role">
                                        <option value="intern"    {{ $staffRole==='intern'    ?'selected':'' }}>Intern</option>
                                        <option value="staff"     {{ $staffRole==='staff'     ?'selected':'' }}>Staff</option>
                                        <option value="admin"     {{ $staffRole==='admin'     ?'selected':'' }}>Admin</option>
                                        <option value="part_time" {{ $staffRole==='part_time' ?'selected':'' }}>Part Time</option>
                                        <option value="staff_ge"  {{ $staffRole==='staff_ge'  ?'selected':'' }}>Staff GE (Support Engineer)</option>
                                    </select>
                                @endif
                            </div>
                            <div class="form-group" id="roleChangeWarning" style="display:none;">
                                <div class="warn-box" style="margin-top:24px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Internship Data Will Be Cleared</strong>
                                    <p>Changing role from Intern to Staff/Admin will permanently delete internship dates and intern leave entitlements.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="staff_status"><i class="fas fa-user-tag"></i> Staff Status</label>
                                <select class="lv-input lv-select" id="staff_status" name="staff_status">
                                    <option value="">Select Status</option>
                                    @foreach(['IBN HQ','KONTRAK','INTERN'] as $s)
                                        <option value="{{ $s }}" {{ old('staff_status',$staff->staff_status)==$s?'selected':'' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="shirt_size"><i class="fas fa-tshirt"></i> Shirt Size</label>
                                <select class="lv-input lv-select" id="shirt_size" name="shirt_size">
                                    <option value="">Select Size</option>
                                    @foreach(['XS','S','M','L','XL','2XL','3XL'] as $size)
                                        <option value="{{ $size }}" {{ old('shirt_size',$staff->shirt_size)==$size?'selected':'' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── CONTACT INFORMATION ── --}}
                <div class="form-card">
                    <div class="form-card-head"><i class="fas fa-address-book"></i><h4>Contact Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone_number_display"><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="text" class="lv-input" id="phone_number_display" data-format="phone" data-hidden-input="phone_number" maxlength="17" placeholder="+60 XX-XXX XXXX" value="{{ old('phone_number', $staff->phone_number) }}">
                                <input type="hidden" id="phone_number" name="phone_number" value="{{ old('phone_number', $staff->phone_number) }}">
                            </div>
                            <div class="form-group">
                                <label for="secondary_phone_number_display"><i class="fas fa-phone-alt"></i> Secondary Phone</label>
                                <input type="text" class="lv-input" id="secondary_phone_number_display" data-format="phone" data-hidden-input="secondary_phone_number" maxlength="17" placeholder="+60 XX-XXX XXXX" value="{{ old('secondary_phone_number', $staff->secondary_phone_number) }}">
                                <input type="hidden" id="secondary_phone_number" name="secondary_phone_number" value="{{ old('secondary_phone_number', $staff->secondary_phone_number) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── PERSONAL INFORMATION ── --}}
                <div class="form-card">
                    <div class="form-card-head"><i class="fas fa-user-circle"></i><h4>Personal Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                                <input type="text" class="lv-input" value="{{ $staff->date_of_birth ? \Carbon\Carbon::parse($staff->date_of_birth)->format('d/m/Y') : 'Auto-calculated from IC' }}" readonly>
                                <div class="form-hint">Auto-calculated from IC Number@if($staff->date_of_birth) — Age: {{ \Carbon\Carbon::parse($staff->date_of_birth)->age }} years old@endif</div>
                            </div>
                            <div class="form-group">
                                <label for="date_joined"><i class="fas fa-calendar-check"></i> Date Joined</label>
                                <input type="date" class="lv-input" id="date_joined" name="date_joined" value="{{ old('date_joined', $staff->date_joined ? \Carbon\Carbon::parse($staff->date_joined)->format('Y-m-d') : '') }}">
                                <div class="form-hint">When staff started working</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="date_confirmed"><i class="fas fa-calendar-check"></i> Date Confirmed</label>
                                <input type="date" class="lv-input" id="date_confirmed" name="date_confirmed" value="{{ old('date_confirmed', $staff->date_confirmed ? \Carbon\Carbon::parse($staff->date_confirmed)->format('Y-m-d') : '') }}">
                                <div class="form-hint">Date probation ended</div>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-chart-line"></i> Years of Experience</label>
                                <input type="text" class="lv-input" id="years_of_experience" name="years_of_experience" value="{{ old('years_of_experience', $staff->years_of_experience) }}" readonly>
                                <div class="form-hint">Auto-calculated from Date Joined</div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:16px;">
                            <label for="ic_address"><i class="fas fa-map-marker-alt"></i> IC Address</label>
                            <textarea class="lv-input" id="ic_address" name="ic_address" rows="3">{{ old('ic_address', $staff->ic_address) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="current_address"><i class="fas fa-home"></i> Current Address</label>
                            <textarea class="lv-input" id="current_address" name="current_address" rows="3">{{ old('current_address', $staff->current_address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ── INTERNSHIP PERIOD (INTERNS ONLY) ── --}}
                @if($staff->role === 'intern')
                <div class="form-card">
                    <div class="form-card-head"><i class="fas fa-calendar-alt"></i><h4>Internship Period</h4></div>
                    <div class="form-card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="internship_start_date"><i class="fas fa-calendar-day"></i> Internship Start Date</label>
                                <input type="date" class="lv-input" id="internship_start_date" name="internship_start_date"
                                    value="{{ old('internship_start_date', $staff->internship_start_date ? \Carbon\Carbon::parse($staff->internship_start_date)->format('Y-m-d') : '') }}">
                                <div class="form-hint">When did internship start?</div>
                            </div>
                            <div class="form-group">
                                <label for="internship_end_date"><i class="fas fa-calendar-check"></i> Internship End Date</label>
                                <input type="date" class="lv-input" id="internship_end_date" name="internship_end_date"
                                    value="{{ old('internship_end_date', $staff->internship_end_date ? \Carbon\Carbon::parse($staff->internship_end_date)->format('Y-m-d') : '') }}">
                                <div class="form-hint">When does internship end?</div>
                            </div>
                        </div>
                        @if(!$staff->internship_start_date || !$staff->internship_end_date)
                        <div class="warn-box">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Important:</strong> Internship dates not set yet. Staff cannot apply for leave until dates are configured.
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- ── PROFESSIONAL INFORMATION ── --}}
                <div class="form-card">
                    <div class="form-card-head"><i class="fas fa-briefcase"></i><h4>Professional Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-group">
                            <label for="academic_qualification"><i class="fas fa-graduation-cap"></i> Academic Qualification</label>
                            <textarea class="lv-input" id="academic_qualification" name="academic_qualification" rows="3">{{ old('academic_qualification', $staff->academic_qualification) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ── FINANCIAL INFORMATION ── --}}
                <div class="form-card">
                    <div class="form-card-head"><i class="fas fa-wallet"></i><h4>Financial Information</h4></div>
                    <div class="form-card-body">
                        <div class="form-group" style="margin-bottom:16px;">
                            <label for="epf_number"><i class="fas fa-id-badge"></i> EPF Number</label>
                            <input type="text" class="lv-input" id="epf_number" name="epf_number" value="{{ old('epf_number', $staff->epf_number) }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="bank_name"><i class="fas fa-university"></i> Bank Name</label>
                                <select class="lv-input lv-select" id="bank_name" name="bank_name">
                                    <option value="">Select Bank</option>
                                    @php
                                        $banks = ['Maybank','CIMB','Public Bank','RHB','Hong Leong Bank','AmBank','Bank Islam','BSN','Bank Rakyat','Affin Bank','Alliance Bank','OCBC','UOB','HSBC','Standard Chartered'];
                                    @endphp
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank }}" {{ old('bank_name',$staff->bank_name)==$bank?'selected':'' }}>{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bank_account_number"><i class="fas fa-credit-card"></i> Bank Account Number</label>
                                <input type="text" class="lv-input" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $staff->bank_account_number) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update Staff Information</button>
                    <a href="{{ route('admin.view-staff', $staff->id) }}" class="btn-cancel"><i class="fas fa-times"></i> Cancel</a>
                </div>

            </form>
        </div>
    </main>
</div>

<script src="{{ asset('js/formatters.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateJoinedInput        = document.getElementById('date_joined');
    const yearsOfExperienceInput = document.getElementById('years_of_experience');

    function calculateYearsOfExperience() {
        const dateJoined = dateJoinedInput.value;
        if (!dateJoined) { yearsOfExperienceInput.value = ''; return; }
        const joinedDate = new Date(dateJoined), today = new Date();
        let years  = today.getFullYear() - joinedDate.getFullYear();
        let months = today.getMonth()    - joinedDate.getMonth();
        if (months < 0 || (months === 0 && today.getDate() < joinedDate.getDate())) { years--; months += 12; }
        if (today.getDate() < joinedDate.getDate()) months--;
        if (years === 0) {
            yearsOfExperienceInput.value = months + ' month' + (months !== 1 ? 's' : '');
        } else if (months === 0) {
            yearsOfExperienceInput.value = years + ' year' + (years !== 1 ? 's' : '');
        } else {
            yearsOfExperienceInput.value = years + ' year' + (years !== 1 ? 's' : '') + ', ' + months + ' month' + (months !== 1 ? 's' : '');
        }
    }
    calculateYearsOfExperience();
    dateJoinedInput.addEventListener('change', calculateYearsOfExperience);

    // Role change warning
    const roleSelect   = document.getElementById('role');
    const warning      = document.getElementById('roleChangeWarning');
    const originalRole = '{{ $staff->role }}';
    if (roleSelect && warning) {
        roleSelect.addEventListener('change', function() {
            warning.style.display = (originalRole === 'intern' && ['staff','admin','superadmin'].includes(this.value)) ? 'block' : 'none';
        });
    }
});
</script>
</body>
</html>
