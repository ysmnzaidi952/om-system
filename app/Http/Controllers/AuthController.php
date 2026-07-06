<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show Register Form
    public function registerShow()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('register');
    }

    // Handle Registration
    public function registerStore(Request $request)
    {
        $request->validate([
            'id_type'   => 'required|in:ic,passport',
            'id_number' => [
                'required',
                'unique:users,id_number',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->id_type === 'ic') {
                        $clean = preg_replace('/[^0-9]/', '', $value);
                        if (strlen($clean) !== 12) {
                            $fail('IC Number must be exactly 12 digits.');
                        }
                    } else {
                        // Passport: alphanumeric, 6-20 chars
                        if (!preg_match('/^[A-Za-z0-9]{6,20}$/', $value)) {
                            $fail('Passport number must be 6-20 alphanumeric characters.');
                        }
                    }
                },
            ],
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|max:150|unique:users,email',
            'role'     => 'required|in:staff,intern,part_time,staff_ge',
            'password' => 'required|min:6|confirmed',
        ], [
            'id_type.required'   => 'Please select ID type.',
            'id_number.required' => 'ID Number is required.',
            'id_number.unique'   => 'This ID Number is already registered.',
            // ... lain sama
        ]);

        User::create([
            'id_number' => preg_replace('/[^A-Za-z0-9]/', '', $request->id_number),
            'id_type'   => $request->id_type,
            'name'      => strtoupper($request->name),
            'email'     => strtolower($request->email),
            'password'  => $request->password,
            'role'      => $request->role,
            'status'    => 'pending',
            'position'  => match($request->role) {
                'intern'    => 'Intern',
                'part_time' => 'Part Timer',
                'staff_ge'  => 'GE Support',
                default     => null,
            },
        ]);

        return redirect()->route('login.show')
            ->with('success', 'Registration successful! Please wait for admin approval.');
    }

    // Show Login Form
    public function loginShow()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('login');
    }

    // Handle Login
    public function loginStore(Request $request)
    {
        $request->validate([
            'id_number' => 'required',
            'password'  => 'required',
        ], [
            'id_number.required' => 'IC / Passport Number is required.',
            'password.required'  => 'Password is required.',
        ]);

        // Clean input — remove dashes/spaces
        $idNumber = preg_replace('/[^A-Za-z0-9]/', '', $request->id_number);

        $user = User::where('id_number', $idNumber)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid ID Number or Password.')->withInput();
        }

        if ($user->status === 'pending') {
            return back()->with('error', 'Your account is pending approval.')->withInput();
        }

        if ($user->status === 'inactive') {
            return back()->with('error', 'Your account has been deactivated.')->withInput();
        }

        Auth::login($user);
        return $this->redirectBasedOnRole();
    }

    // Handle Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show Forgot Password Form
     */
    public function forgotPasswordShow()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('forgot-password');
    }

    /**
     * Handle Forgot Password Request
     */
    public function forgotPasswordStore(Request $request)
    {
        // Validation
        $request->validate([
            'id_number' => 'required',
        ], [
            'id_number.required' => 'IC / Passport Number is required.',
        ]);

        // Clean input — remove dashes and spaces
        $idNumber = preg_replace('/[^A-Za-z0-9]/', '', $request->id_number);

        // Find user by id_number
        $user = User::where('id_number', $idNumber)->first();

        if (!$user) {
            return back()->with('error', 'No account found with this IC / Passport Number.')->withInput();
        }

        // Check if user is pending or inactive
        if ($user->status === 'pending') {
            return back()->with('error', 'Your account is still pending approval. Please contact admin.')->withInput();
        }

        if ($user->status === 'inactive') {
            return back()->with('error', 'Your account has been deactivated. Please contact admin.')->withInput();
        }

        // Generate reset token
        $token = Str::random(64);

        // Save token and expiration (1 hour from now)
        $user->reset_token = $token;
        $user->reset_token_expires_at = Carbon::now()->addHour();
        $user->save();

        // Generate reset URL
        $resetUrl = route('password.reset', ['token' => $token]);

        return redirect()->route('password.request')
            ->with('success', 'Password reset link generated! Click the link below to reset your password:')
            ->with('reset_url', $resetUrl)
            ->with('user_name', $user->name);
    }

    /**
     * Show Reset Password Form
     */
    public function resetPasswordShow($token)
    {
        // Find user with valid token
        $user = User::where('reset_token', $token)
            ->where('reset_token_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('login.show')
                ->with('error', 'Invalid or expired reset link. Please request a new one.');
        }

        return view('reset-password', compact('token', 'user'));
    }

    /**
     * Handle Password Reset
     */
    public function resetPasswordStore(Request $request)
    {
        // Validation
        $request->validate([
            'token'    => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Find user with valid token
        $user = User::where('reset_token', $request->token)
            ->where('reset_token_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->route('login.show')
                ->with('error', 'Invalid or expired reset link. Please request a new one.');
        }

        // Update password
        $user->password = $request->password; // Auto-hashed by model
        $user->reset_token = null;
        $user->reset_token_expires_at = null;
        $user->save();

        return redirect()->route('login.show')
            ->with('success', 'Password reset successfully! You can now login with your new password.');
    }

    //  UPDATED: Helper method to redirect based on user role (WITH SUPERADMIN SUPPORT)
    private function redirectBasedOnRole()
    {
        return match (Auth::user()->role) {
            'superadmin' => redirect()->route('admin.dashboard'),
            'admin'      => redirect()->route('admin.dashboard'),
            'intern'     => redirect()->route('intern.dashboard'),
            'staff'      => redirect()->route('staff.dashboard'),
            'part_time'  => redirect()->route('staff.dashboard'),
            'staff_ge'   => redirect()->route('staff.dashboard'),
            default      => redirect()->route('login.show'),
        };
    }
}
