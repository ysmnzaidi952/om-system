<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Helpers\IcHelper;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_number',
        'id_type',
        'name',
        'email',
        'profile_photo',
        'password',
        'role',
        'status',
        'reset_token',
        'reset_token_expires_at',
        'date_joined',
        'date_confirmed',
        'shirt_size',
        'staff_status',
        'position',
        'date_of_birth',
        'academic_qualification',
        'years_of_experience',
        'epf_number',
        'phone_number',
        'secondary_phone_number',
        'bank_name',
        'bank_account_number',
        'ic_address',
        'current_address',
        'internship_start_date',    //  ADD THIS
        'internship_end_date',      //  ADD THIS
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_joined' => 'date',
            'date_confirmed' => 'date',
            'date_of_birth' => 'date',
            'internship_start_date' => 'date',  //  ADD THIS
            'internship_end_date' => 'date',    //  ADD THIS
        ];
    }

    /**
     * Override to return actual ID
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Boot method - Auto-calculate DOB from IC
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Only extract DOB if id_type is 'ic'
            if ($user->id_type === 'ic' && $user->id_number && !$user->date_of_birth) {
                $user->date_of_birth = IcHelper::extractDateOfBirth($user->id_number);
            }
        });

        static::updating(function ($user) {
            if ($user->id_type === 'ic' && $user->isDirty('id_number') && !$user->isDirty('date_of_birth')) {
                $user->date_of_birth = IcHelper::extractDateOfBirth($user->id_number);
            }
        });
    }

    /**
     * Get age from IC
     */
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return \Carbon\Carbon::parse($this->date_of_birth)->age;
        }
        if ($this->id_type === 'ic' && $this->id_number) {
            return IcHelper::calculateAge($this->id_number);
        }
        return null; // passport users without DOB — can't calculate age
    }

    // ========================================
    // ROLE CHECK METHODS
    // ========================================

    /**
     * Check if user is Superadmin
     */
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    /**
     * Check if user is Admin (including superadmin)
     */
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * Check if user is Staff (including superadmin for staff functions)
     */
    public function isStaff()
    {
        return in_array($this->role, ['staff', 'superadmin']);
    }

    /**
     * Check if user is Intern
     */
    public function isIntern()
    {
        return $this->role === 'intern';
    }

    /**
     * Check if user is Part Time
     */
    public function isPartTime()
    {
        return $this->role === 'part_time';
    }

    /**
     * Check if user is Staff GE
     */
    public function isStaffGe()
    {
        return $this->role === 'staff_ge';
    }

    /**
     * Check if user is exempt from daily leave limit
     * (part_time, staff_ge, and Customer Support are exempt)
     */
    public function isExemptFromDailyLimit()
    {
        return in_array($this->role, ['part_time', 'staff_ge']) || $this->isCustomerSupport();
    }

    /**
     * Check if user can access admin functions
     */
    public function canAccessAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    /**
     * Check if user can access staff functions
     */
    public function canAccessStaff()
    {
        return in_array($this->role, ['staff', 'superadmin']);
    }

    /**
     * Check if user is Customer Support Engineer
     */
    public function isCustomerSupport()
    {
        return $this->position &&
               (stripos($this->position, 'Customer Support') !== false);
    }

    /**
     * Get dashboard route name based on role
     */
    public function getDashboardRouteAttribute()
    {
        return match($this->role) {
            'superadmin' => 'admin.dashboard',
            'admin'      => 'admin.dashboard',
            'staff'      => 'staff.dashboard',
            'intern'     => 'intern.dashboard',
            'part_time'  => 'staff.dashboard',
            'staff_ge'   => 'staff.dashboard',
            default      => 'admin.dashboard',
        };
    }

    /**
     * Get team staff route name based on role
     */
    public function getTeamStaffRouteAttribute()
    {
        return match($this->role) {
            'superadmin' => 'admin.team-staff',
            'admin'      => 'admin.team-staff',
            'staff'      => 'staff.team-staff',
            'intern'     => 'intern.team-staff',
            'part_time'  => 'staff.team-staff',
            'staff_ge'   => 'staff.team-staff',
            default      => 'admin.team-staff',
        };
    }

    // ========================================
    // LEAVE RELATIONSHIPS
    // ========================================

    /**
     * Relationship: User has many Leave Applications
     */
    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    /**
     * Relationship: User has many Leave Entitlements
     */
    public function leaveEntitlements()
    {
        return $this->hasMany(LeaveEntitlement::class);
    }

    /**
     * Leave applications approved by this Admin
     */
    public function adminApprovedLeaves()
    {
        return $this->hasMany(LeaveApplication::class, 'approved_by');
    }

    /**
     * Get current year's leave entitlement
     */
    public function currentYearEntitlement()
    {
        return $this->leaveEntitlements()
                    ->where('year', date('Y'))
                    ->first();
    }


    /**
     * Get or create leave entitlement for a specific year
     * For interns: Uses internship start year (not current year)
     */
    public function getOrCreateEntitlement($year = null)
    {
        //  INTERN LOGIC: Use internship start year
        if ($this->role === 'intern') {
            // If intern has set their internship start date, use that year
            if ($this->internship_start_date) {
                $year = \Carbon\Carbon::parse($this->internship_start_date)->year;
            } else {
                // If not set, use current year as placeholder
                $year = $year ?? date('Y');
            }

            $entitlement = LeaveEntitlement::where('user_id', $this->id)
                ->where('year', $year)
                ->first();

            if (!$entitlement) {
                $entitlement = LeaveEntitlement::create([
                    'user_id' => $this->id,
                    'year' => $year,
                    'annual_leave_total' => 5, // 5 days for entire internship
                    'annual_leave_used' => 0,
                    'medical_leave_total' => 5, // 5 days for entire internship
                    'medical_leave_used' => 0,
                ]);
            }

            return $entitlement;
        }

        //  STAFF LOGIC: Use provided year or current year
        $year = $year ?? date('Y');

        $entitlement = LeaveEntitlement::where('user_id', $this->id)
            ->where('year', $year)
            ->first();

        if (!$entitlement) {
            $entitlement = LeaveEntitlement::create([
                'user_id' => $this->id,
                'year' => $year,
                'annual_leave_total' => 14, // 14 days per year for staff
                'annual_leave_used' => 0,
                'medical_leave_total' => 14, // 14 days per year for staff
                'medical_leave_used' => 0,
            ]);
        }

        return $entitlement;

        //  PART TIME & STAFF GE: No yearly limit tracking
        if (in_array($this->role, ['part_time', 'staff_ge'])) {
            $year = $year ?? date('Y');

            $entitlement = LeaveEntitlement::where('user_id', $this->id)
                ->where('year', $year)
                ->first();

            if (!$entitlement) {
                $entitlement = LeaveEntitlement::create([
                    'user_id'             => $this->id,
                    'year'                => $year,
                    'annual_leave_total'  => 0,
                    'annual_leave_used'   => 0,
                    'medical_leave_total' => 0,
                    'medical_leave_used'  => 0,
                ]);
            }

            return $entitlement;
        }
    }
    /**
     * Get profile photo URL or generate default avatar
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            // Check if file exists in storage
            $fullPath = storage_path('app/public/' . $this->profile_photo);

            if (file_exists($fullPath)) {
                return asset('storage/' . $this->profile_photo);
            }

            // If file doesn't exist, log error and clear from database
            \Log::warning("Profile photo file missing for user {$this->id}: {$this->profile_photo}");
        }

        // Return null for CSS default avatar
        return null;
    }

    /**
     * Get initials for avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get avatar color based on name
     */
    public function getAvatarColorAttribute()
    {
        $colors = ['#818cf8', '#a78bfa', '#fb7185', '#34d399', '#fbbf24', '#22d3ee', '#f472b6', '#ec4899'];
        $index = ord(strtolower($this->name[0])) % count($colors);
        return $colors[$index];
    }
}
