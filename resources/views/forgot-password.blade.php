<!-- C:\laragon\www\om_system\resources\views\forgot-password.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | O&M HRCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-header">
                <h1>Forgot Password</h1>
                <p>Enter your IC Number to reset your password</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}

                    @if(session('reset_url'))
                        <div style="margin-top: 1.5rem; padding: 1.5rem; background: #f8f9fa; border-radius: 0.5rem; border: 1px solid #dee2e6;">
                            <p style="margin-bottom: 1rem; font-weight: 600;">Reset Link for: {{ session('user_name') }}</p>
                            <a href="{{ session('reset_url') }}"
                               style="color: var(--primary-color); word-break: break-all; display: block; margin-bottom: 1rem;">
                                {{ session('reset_url') }}
                            </a>
                            <p style="color: #666; font-size: 1.3rem; margin: 0;">
                                <i class="fas fa-clock"></i> This link will expire in 1 hour
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="ic">IC Number <span class="required">*</span></label>
                    <input
                        type="text"
                        id="ic"
                        name="ic"
                        value="{{ old('ic') }}"
                        maxlength="14"
                        placeholder="YYMMDD-PP-####"
                        required
                    >
                    <small style="color: var(--light-color); display: block; margin-top: 0.5rem;">
                        Enter the IC Number you used to register
                    </small>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Send Reset Link</button>
            </form>

            <div class="auth-footer">
                <p>Remember your password? <a href="{{ route('login.show') }}">Login here</a></p>
            </div>
        </div>
    </div>

    <script>
        // Malaysian IC Number Auto-Formatter
        function formatICNumber(input) {
            let value = input.value.replace(/\D/g, '');

            if (value.length > 12) {
                value = value.substring(0, 12);
            }

            let formatted = '';
            if (value.length > 0) {
                formatted = value.substring(0, 6);
                if (value.length >= 7) {
                    formatted += '-' + value.substring(6, 8);
                }
                if (value.length >= 9) {
                    formatted += '-' + value.substring(8, 12);
                }
            }

            input.value = formatted;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const icInput = document.getElementById('ic');

            icInput.addEventListener('input', function() {
                formatICNumber(this);
            });

            icInput.addEventListener('paste', function() {
                setTimeout(() => formatICNumber(this), 0);
            });

            // Remove dashes before submission
            const form = icInput.closest('form');
            form.addEventListener('submit', function(e) {
                const cleanIC = icInput.value.replace(/\D/g, '');

                let hiddenInput = form.querySelector('input[name="ic_clean"]');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'ic_clean';
                    form.appendChild(hiddenInput);
                }
                hiddenInput.value = cleanIC;

                icInput.name = 'ic_display';
                hiddenInput.name = 'ic';
            });

            if (icInput.value) {
                formatICNumber(icInput);
            }
        });
    </script>
</body>
</html>
