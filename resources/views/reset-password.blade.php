<!-- C:\laragon\www\om_system\resources\views\reset-password.blade.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | O&M HRCare</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-header">
                <h1>Reset Password</h1>
                <p>Enter your new password for: <strong>{{ $user->name }}</strong></p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="password">New Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required minlength="6">
                    <small style="color: var(--light-color); display: block; margin-top: 0.5rem;">
                        Minimum 6 characters
                    </small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Reset Password</button>
            </form>

            <div class="auth-footer">
                <p>Remember your password? <a href="{{ route('login.show') }}">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
