<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $leave_type
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property float $total_days
 * @property bool $is_half_day
 * @property string|null $half_day_period
 * @property string $reason
 * @property string|null $attachment
 * @property string $status
 * @property int|null $approved_by
 * @property \Carbon\Carbon|null $approved_at
 * @property string|null $rejection_reason
 *
 * @property-read User $user
 * @property-read User|null $approvedBy
 */
class LeaveApplication extends Model
{
    use HasFactory;


    protected static function boot()
    {
        parent::boot();

        // Auto-set Malaysia timezone when creating leave application
        static::creating(function ($model) {
            $model->created_at = Carbon::now('Asia/Kuala_Lumpur');
        });
    }


    protected $fillable = [
        'user_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'is_half_day',
        'half_day_period',
        'reason',
        'attachment',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'approval_note',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'total_days' => 'decimal:1',
        'is_half_day' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ========================================
    // RELATIONSHIPS
    // ========================================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ========================================
    // LEAVE TYPE CONFIGURATIONS
    // ========================================

    /**
     * Leave types that require balance deduction
     */
    public static $countedLeaveTypes = ['AL', 'EL', 'MC', 'HALF_DAY_AL', 'HALF_DAY_EL'];

    /**
     * Leave types that don't require balance checking
     */
    public static $unCountedLeaveTypes = ['CL', 'WFH', 'ML', 'PL', 'RL', 'MRL', 'SL'];

    /**
     * Fixed day leave types with their limits
     */
    public static $fixedDayLeaveTypes = [
        'CL' => 3,   // Compassionate Leave - exactly 3 days (calendar days)
        'MRL' => 3,  // Married Leave - exactly 3 days (calendar days)
        'ML' => 98,  // Maternity Leave - max 98 days (calendar days)
        'PL' => 7,   // Paternity Leave - max 7 days (calendar days)
    ];

    /**
     * Leave types exempt from daily limit
     */
    public static $dailyLimitExemptTypes = ['ML', 'PL'];

    /**
     * Leave types that allow backdating with their limits (in days)
     */
    public static $backdatingAllowedTypes = [
        'AL' => 0,
        'HALF_DAY_AL' => 0,
        'EL' => 118,
        'HALF_DAY_EL' => 118,
        'MC' => 118,
        'CL' => 118,
        'WFH' => 118,
        'ML' => 118,  //nanti tukar balik jadi 30 hari
        'PL' => 118,
        'RL' => 118,
        'MRL' => 118,
        'SL' => 118,
    ];

    /**
     * Leave types that require 7-day advance application
     */
    public static $advanceApplicationTypes = ['AL', 'HALF_DAY_AL'];

    // ========================================
    // ACCESSOR ATTRIBUTES
    // ========================================

    public function getLeaveTypeNameAttribute()
    {
        return match($this->leave_type) {
            'AL' => 'Annual Leave',
            'EL' => 'Emergency Leave',
            'MC' => 'Medical Leave',
            'CL' => 'Compassionate Leave',
            'WFH' => 'Work From Home',
            'ML' => 'Maternity Leave',
            'PL' => 'Paternity Leave',
            'RL' => 'Replacement Leave',
            'MRL' => 'Married Leave',
            'HALF_DAY_AL' => 'Half Day Annual Leave',
            'HALF_DAY_EL' => 'Half Day Emergency Leave',
            'SL' => 'Special Leave',  //  ADD THIS
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            'waiting_list' => 'info',
            'special_case_approved' => 'primary',
            default => 'secondary',
        };
    }

    /**
     * Check if leave type requires balance checking
     */
    public function requiresBalanceCheck()
    {
        // part_time & staff_ge tiada balance limit — skip deduction
        if ($this->user && in_array($this->user->role, ['part_time', 'staff_ge'])) {
            return false;
        }

        return in_array($this->leave_type, self::$countedLeaveTypes);
    }

    /**
     * Check if leave type has fixed days requirement
     */
    public function hasFixedDaysRequirement()
    {
        return array_key_exists($this->leave_type, self::$fixedDayLeaveTypes);
    }

    /**
     * Check if exempt from daily limit
     */
    public function isExemptFromDailyLimit()
    {
        return in_array($this->leave_type, self::$dailyLimitExemptTypes) ||
            ($this->user && $this->user->isCustomerSupport()) ||
            ($this->user && in_array($this->user->role, ['part_time', 'staff_ge']));
    }

    /**
     * Check if leave type allows backdating
     */
    public function allowsBackdating()
    {
        return array_key_exists($this->leave_type, self::$backdatingAllowedTypes);
    }

    /**
     * Get maximum backdating days allowed for this leave type
     */
    public function getMaxBackdatingDays()
    {
        return self::$backdatingAllowedTypes[$this->leave_type] ?? 0;
    }

    /**
     * Check if leave type requires 7-day advance application
     */
    public function requiresAdvanceApplication()
    {
        return in_array($this->leave_type, self::$advanceApplicationTypes);
    }

    // ========================================
    // SCOPES
    // ========================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->whereIn('status', ['approved', 'special_case_approved']);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeWaitingList($query)
    {
        return $query->where('status', 'waiting_list');
    }

    public function scopeSpecialCaseApproved($query)
    {
        return $query->where('status', 'special_case_approved');
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('start_date', $year)
                    ->whereMonth('start_date', $month);
    }

    public function scopeForYear($query, $year)
    {
        return $query->whereYear('start_date', $year);
    }

    // ========================================
    // STATUS CHECK METHODS
    // ========================================

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return in_array($this->status, ['approved', 'special_case_approved']);
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isWaitingList()
    {
        return $this->status === 'waiting_list';
    }

    public function isSpecialCaseApproved()
    {
        return $this->status === 'special_case_approved';
    }

    // ========================================
    // DATE CALCULATION
    // ========================================

    /**
     * Calculate total days between start and end date (inclusive)
     * Supports half-day (0.5)
     */
    public static function calculateDays($start_date, $end_date, $is_half_day = false)
    {
        if ($is_half_day) {
            return 0.5;
        }

        $start = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);

        return $start->diffInDays($end) + 1;
    }

    /**
     * Get all dates covered by this leave application
     */
    public function getLeaveDates()
    {
        $dates = [];

        $startStr = $this->start_date->format('Y-m-d');
        $endStr = $this->end_date->format('Y-m-d');



        $start = Carbon::createFromFormat('Y-m-d', $startStr);
        $end = Carbon::createFromFormat('Y-m-d', $endStr);

        while ($start->lte($end)) {
            $dates[] = $start->format('Y-m-d');
            $start->addDay();
        }

        return $dates;
    }

    /**
     * Auto-calculate end date for fixed-day leave types (calendar days)
     */
    public static function autoCalculateEndDate($leave_type, $start_date)
    {
        if (!array_key_exists($leave_type, self::$fixedDayLeaveTypes)) {
            return null;
        }

        $days = self::$fixedDayLeaveTypes[$leave_type];
        $start = Carbon::parse($start_date);

        // Add days minus 1 (because start date is day 1)
        return $start->copy()->addDays($days - 1)->format('Y-m-d');
    }
}
