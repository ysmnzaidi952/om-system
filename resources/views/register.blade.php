{{-- C:\laragon\www\om_system\resources\views\register.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | O&M HRCare</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-container">

            <div class="auth-header">
                <h1>Register</h1>
                <p>Create your staff account</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST" id="registerForm">
                @csrf

                {{-- ── ID TYPE SELECTOR ── --}}
                <div class="form-group">
                    <label for="id_type">ID Type <span class="required">*</span></label>
                    <select id="id_type" name="id_type" required>
                        <option value="ic"       {{ old('id_type', 'ic') == 'ic'       ? 'selected' : '' }}>Malaysian IC</option>
                        <option value="passport" {{ old('id_type')        == 'passport' ? 'selected' : '' }}>Passport</option>
                    </select>
                </div>

                {{-- ── IC NUMBER FIELD ── --}}
                <div class="form-group" id="field_ic">
                    <label for="id_number_ic">IC Number <span class="required">*</span></label>
                    <input
                        type="text"
                        id="id_number_ic"
                        maxlength="14"
                        placeholder="YYMMDD-PP-####"
                        data-format="ic"
                        value="{{ old('id_type', 'ic') == 'ic' ? old('id_number') : '' }}"
                    >
                    <small>Format: 010203-01-1234</small>
                </div>

                {{-- ── PASSPORT NUMBER FIELD ── --}}
                <div class="form-group" id="field_passport" style="display:none;">
                    <label for="id_number_passport">Passport Number <span class="required">*</span></label>
                    <input
                        type="text"
                        id="id_number_passport"
                        maxlength="20"
                        placeholder="e.g. A12345678"
                        style="text-transform:uppercase;"
                        value="{{ old('id_type') == 'passport' ? old('id_number') : '' }}"
                    >
                    <small>Enter passport number as printed on your passport</small>
                </div>

                {{-- Hidden input — nilai sebenar yang dihantar ke controller --}}
                <input type="hidden" id="id_number" name="id_number" value="{{ old('id_number') }}">

                {{-- ── FULL NAME ── --}}
                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                {{-- ── EMAIL ── --}}
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── ROLE ── --}}
                <div class="form-group">
                    <label for="role">Register As <span class="required">*</span></label>
                    <select id="role" name="role" required>
                        <option value="staff"     {{ old('role') == 'staff'     ? 'selected' : '' }}>Staff</option>
                        <option value="intern"    {{ old('role') == 'intern'    ? 'selected' : '' }}>Intern</option>
                        <option value="part_time" {{ old('role') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="staff_ge"  {{ old('role') == 'staff_ge'  ? 'selected' : '' }}>Staff GE (Support Engineer)</option>
                    </select>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── PHONE NUMBER ── --}}
                <div class="form-group">
                    <label for="phone_number_display">Phone Number</label>
                    <input
                        type="text"
                        id="phone_number_display"
                        data-format="phone"
                        data-hidden-input="phone_number"
                        maxlength="17"
                        placeholder="+60 XX-XXX XXXX"
                        value="{{ old('phone_number') }}"
                    >
                    <input type="hidden" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                    <small>Format: +60 16-789 0123 or +60 11-5678 9012</small>
                </div>

                {{-- ── PASSWORD ── --}}
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%;">Create Account</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="{{ route('login.show') }}">Login here</a></p>
            </div>

        </div>
    </div>

    <script src="{{ asset('js/formatters.js') }}"></script>
    <script>
        // Toggle antara IC field dan Passport field
        function toggleIdField(type) {
            const icField       = document.getElementById('field_ic');
            const passportField = document.getElementById('field_passport');

            if (type === 'passport') {
                icField.style.display       = 'none';
                passportField.style.display = 'block';
            } else {
                icField.style.display       = 'block';
                passportField.style.display = 'none';
            }
        }

        // Run on page load — untuk handle old() value selepas validation fail
        document.addEventListener('DOMContentLoaded', function () {
            const idTypeSelect = document.getElementById('id_type');
            toggleIdField(idTypeSelect.value);

            // Listen untuk perubahan ID type
            idTypeSelect.addEventListener('change', function () {
                toggleIdField(this.value);
                // Clear both fields bila tukar type
                document.getElementById('id_number_ic').value       = '';
                document.getElementById('id_number_passport').value = '';
                document.getElementById('id_number').value          = '';
            });
        });

        // Sync hidden input sebelum form disubmit
        document.getElementById('registerForm').addEventListener('submit', function () {
            const type = document.getElementById('id_type').value;

            let rawValue = '';
            if (type === 'passport') {
                rawValue = document.getElementById('id_number_passport').value;
                // Passport: uppercase, strip spaces only
                document.getElementById('id_number').value = rawValue.trim().toUpperCase();
            } else {
                rawValue = document.getElementById('id_number_ic').value;
                // IC: strip dashes and spaces → 12 digits sahaja
                document.getElementById('id_number').value = rawValue.replace(/[^0-9]/g, '');
            }
        });
    </script>
</body>
</html>
