<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    /**
     * Show user profile
     */
    public function show()
    {
        $user = Auth::user();
        $staff = $user; // for sidebar compatibility
        return view('profile.show', compact('user', 'staff'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        $staff = $user; // for sidebar compatibility
        return view('profile.edit', compact('user', 'staff'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        //  DECLARE NEWROLE SEKALI DI SINI
        $newRole = $request->role ?? $user->role;

        //  BASE VALIDATION
        $rules = [
            'name' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'phone_number' => 'nullable|string|max:20',
            'secondary_phone_number' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'date_joined' => 'nullable|date',
            'shirt_size' => 'nullable|string|max:10',
            'academic_qualification' => 'nullable|string',
            'years_of_experience' => 'nullable|string|max:50',
            'epf_number' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:30',
            'ic_address' => 'nullable|string',
            'current_address' => 'nullable|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'nullable|in:intern,staff,admin,superadmin,part_time,staff_ge',
        ];

        //  ADD INTERN-SPECIFIC VALIDATION (only if staying as intern)
        if ($user->role === 'intern' && $newRole === 'intern') {
            $rules['internship_start_date'] = 'required|date';
            $rules['internship_end_date'] = 'required|date|after:internship_start_date';
        }

        $messages = [
            'internship_start_date.required' => 'Internship start date is required',
            'internship_end_date.required' => 'Internship end date is required',
            'internship_end_date.after' => 'Internship end date must be after start date',
            'profile_photo.image' => 'Profile photo must be an image',
            'profile_photo.mimes' => 'Profile photo must be jpg, jpeg, or png',
            'profile_photo.max' => 'Profile photo must not exceed 2MB',
        ];

        $request->validate($rules, $messages);

        //  HANDLE PROFILE PHOTO UPLOAD
        $photoUploaded = false;
        if ($request->hasFile('profile_photo')) {
            try {
                // Delete old photo if exists
                if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                // Create ImageManager with GD driver
                $manager = new ImageManager(new Driver());

                // Read and resize image
                $image = $manager->read($request->file('profile_photo'));
                $image->cover(600, 600);

                // Generate unique filename
                // ── UPDATED: $user->ic → $user->id_number (column renamed in migration) ──
                $filename = 'profile_photos/' . $user->id_number . '_' . time() . '.jpg';

                // Ensure directory exists
                if (!Storage::disk('public')->exists('profile_photos')) {
                    Storage::disk('public')->makeDirectory('profile_photos');
                }

                $encodedImage = $image->toJpeg(85);
                Storage::disk('public')->put($filename, (string) $encodedImage);

                if (Storage::disk('public')->exists($filename)) {
                    $user->profile_photo = $filename;
                    $photoUploaded = true;
                } else {
                    return back()->withErrors(['profile_photo' => 'Failed to save photo. Please try again.']);
                }

            } catch (\Exception $e) {
                \Log::error('Profile Photo Upload Error: ' . $e->getMessage());
                return back()->withErrors(['profile_photo' => 'Failed to upload photo: ' . $e->getMessage()]);
            }
        }

        //  UPDATE USER INFORMATION
        $updateData = [
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'secondary_phone_number' => $request->secondary_phone_number,
            'position' => $request->position,
            'date_joined' => $request->date_joined,
            'shirt_size' => $request->shirt_size,
            'academic_qualification' => $request->academic_qualification,
            'years_of_experience' => $request->years_of_experience,
            'epf_number' => $request->epf_number,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'ic_address' => $request->ic_address,
            'current_address' => $request->current_address,
        ];

        //  ADD INTERNSHIP DATES FOR INTERNS (only if staying as intern)
        if ($user->role === 'intern' && $newRole === 'intern') {
            $updateData['internship_start_date'] = $request->internship_start_date;
            $updateData['internship_end_date'] = $request->internship_end_date;

            // Update leave entitlement year if start date changed
            if ($user->internship_start_date != $request->internship_start_date) {
                $newYear = Carbon::parse($request->internship_start_date)->year;
                $oldYear = $user->internship_start_date ? Carbon::parse($user->internship_start_date)->year : null;

                if ($oldYear && $oldYear != $newYear) {
                    $entitlement = \App\Models\LeaveEntitlement::where('user_id', $user->id)
                        ->where('year', $oldYear)
                        ->first();

                    if ($entitlement) {
                        $entitlement->update(['year' => $newYear]);
                    }
                }
            }
        }

        //  ROLE CHANGE LOGIC: Intern → Staff/Admin/Superadmin
        if ($user->role === 'intern' && in_array($newRole, ['staff', 'admin', 'superadmin'])) {
            // 1. Clear internship dates
            $updateData['internship_start_date'] = null;
            $updateData['internship_end_date'] = null;

            // 2. Delete ALL intern leave entitlements
            \App\Models\LeaveEntitlement::where('user_id', $user->id)->delete();

            // 3. Create new staff entitlement for current year (14AL + 14MC)
            \App\Models\LeaveEntitlement::create([
                'user_id'             => $user->id,
                'year'                => date('Y'),
                'annual_leave_total'  => 14,
                'annual_leave_used'   => 0,
                'medical_leave_total' => 14,
                'medical_leave_used'  => 0,
            ]);
        }


        //  ROLE CHANGE: Tukar KE part_time atau staff_ge
        if (in_array($newRole, ['part_time', 'staff_ge']) && !in_array($user->role, ['part_time', 'staff_ge'])) {
            \App\Models\LeaveEntitlement::where('user_id', $user->id)->update([
                'annual_leave_total'  => 0,
                'annual_leave_used'   => 0,
                'medical_leave_total' => 0,
                'medical_leave_used'  => 0,
            ]);
        }

        //  ROLE CHANGE: Tukar DARI part_time/staff_ge ke staff/admin
        if (in_array($user->role, ['part_time', 'staff_ge']) && in_array($newRole, ['staff', 'admin', 'superadmin'])) {
            \App\Models\LeaveEntitlement::where('user_id', $user->id)->delete();
            \App\Models\LeaveEntitlement::create([
                'user_id'             => $user->id,
                'year'                => date('Y'),
                'annual_leave_total'  => 14,
                'annual_leave_used'   => 0,
                'medical_leave_total' => 14,
                'medical_leave_used'  => 0,
            ]);
        }



        //  UPDATE ROLE
        if ($request->filled('role')) {
            $updateData['role'] = $newRole;
        }

        $user->update($updateData);

        //  HANDLE PASSWORD CHANGE
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        //  SUCCESS MESSAGE
        $successMsg = 'Profile updated successfully!';
        if ($photoUploaded) {
            $successMsg .= ' Profile photo uploaded.';
        }

        return redirect()->route('profile.show')->with('success', $successMsg);
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            try {
                if (Storage::disk('public')->exists($user->profile_photo)) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                $user->update(['profile_photo' => null]);

                return back()->with('success', 'Profile photo deleted successfully!');

            } catch (\Exception $e) {
                \Log::error('Profile Photo Delete Error: ' . $e->getMessage());
                return back()->with('error', 'Failed to delete profile photo.');
            }
        }

        return back()->with('error', 'No profile photo to delete.');
    }
}
