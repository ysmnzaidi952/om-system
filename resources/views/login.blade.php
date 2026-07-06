{{-- C:\laragon\www\om_system\resources\views\login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | O&M HRCare</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-container">

            <div class="auth-header">
                <h1>Login</h1>
                <p>Welcome back to O&M-HSIS</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="id_number_display">IC / Passport Number <span class="required">*</span></label>
                    <input
                        type="text"
                        id="id_number_display"
                        maxlength="20"
                        placeholder="IC: YYMMDD-PP-#### or Passport"
                        value="{{ old('id_number') }}"
                        required
                    >
                    {{-- Hidden input yang dihantar ke controller --}}
                    <input type="hidden" id="id_number" name="id_number">
                    <small style="color:#4a7a76;">Malaysian staff: enter IC number. Foreign staff: enter passport number.</small>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div style="text-align: right; margin-top: -0.5rem; margin-bottom: 1.5rem;">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="{{ route('register.show') }}">Register here</a></p>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const displayInput = document.getElementById('id_number_display');
            const hiddenInput  = document.getElementById('id_number');
            const form         = document.getElementById('loginForm');

            // Auto-format IC while typing (YYMMDD-PP-####)
            // Tapi kalau passport (ada huruf), jangan format
            displayInput.addEventListener('input', function () {
                const val = this.value;

                // Check sama ada input ada huruf — kalau ada, ini passport
                const hasLetter = /[a-zA-Z]/.test(val);

                if (!hasLetter) {
                    // Format as IC
                    let digits = val.replace(/\D/g, '');
                    if (digits.length > 12) digits = digits.substring(0, 12);

                    let formatted = '';
                    if (digits.length > 0) {
                        formatted = digits.substring(0, 6);
                        if (digits.length >= 7) formatted += '-' + digits.substring(6, 8);
                        if (digits.length >= 9) formatted += '-' + digits.substring(8, 12);
                    }
                    this.value = formatted;
                } else {
                    // Passport — uppercase, allow alphanumeric only
                    this.value = val.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
                }
            });

            // Before submit — clean and put into hidden input
            form.addEventListener('submit', function () {
                const val        = displayInput.value;
                const hasLetter  = /[a-zA-Z]/.test(val);

                if (!hasLetter) {
                    // IC — strip dashes → 12 digits
                    hiddenInput.value = val.replace(/\D/g, '');
                } else {
                    // Passport — uppercase alphanumeric
                    hiddenInput.value = val.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
                }
            });

            // Restore formatted display on page load (after validation fail)
            const oldVal = displayInput.value;
            if (oldVal && !/[a-zA-Z]/.test(oldVal)) {
                let digits = oldVal.replace(/\D/g, '');
                let formatted = '';
                if (digits.length > 0) {
                    formatted = digits.substring(0, 6);
                    if (digits.length >= 7) formatted += '-' + digits.substring(6, 8);
                    if (digits.length >= 9) formatted += '-' + digits.substring(8, 12);
                }
                displayInput.value = formatted;
            }
        });
    </script>
</body>
</html>
