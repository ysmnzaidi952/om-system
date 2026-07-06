<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DailyLeaveCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_date',
        'total_count',
        'customer_support_count',
        'other_staff_count',
    ];

    protected $casts = [
        'leave_date' => 'date',
    ];

    /**
     * Get or create daily leave count for a specific date
     */
    public static function getOrCreate($date)
    {
        return self::firstOrCreate(
            ['leave_date' => Carbon::parse($date)->format('Y-m-d')],
            [
                'total_count' => 0,
                'customer_support_count' => 0,
                'other_staff_count' => 0,
            ]
        );
    }

    /**
     *  Check if daily limit reached (2 staff max - UPDATED FROM 3)
     * Returns: ['canApprove' => bool, 'message' => string, 'currentCount' => int]
     */
    public static function canApproveLeave($leaveApplication)
    {
        // If exempt from daily limit, always allow
        if ($leaveApplication->isExemptFromDailyLimit()) {
            return ['canApprove' => true, 'message' => '', 'currentCount' => 0];
        }

        $dates = $leaveApplication->getLeaveDates();
        $problematicDates = [];

        foreach ($dates as $date) {
            $dailyCount = self::getOrCreate($date);

            //  NEW LIMIT: 2 other staff max (changed from 3)
            if ($dailyCount->other_staff_count >= 2) {
                $problematicDates[] = [
                    'date' => Carbon::parse($date)->format('d/m/Y'),
                    'count' => $dailyCount->other_staff_count
                ];
            }
        }

        if (!empty($problematicDates)) {
            $datesList = implode(', ', array_column($problematicDates, 'date'));
            return [
                'canApprove' => false,
                'message' => 'Daily leave limit (2 staff) reached for: ' . $datesList,
                'currentCount' => $problematicDates[0]['count']
            ];
        }

        return ['canApprove' => true, 'message' => '', 'currentCount' => $dailyCount->other_staff_count ?? 0];
    }

    /**
     *  Check current count for specific dates (for waiting list logic)
     */
    public static function getCurrentCountForDates($dates)
    {
        $maxCount = 0;

        foreach ($dates as $date) {
            $dailyCount = self::where('leave_date', $date)->first();
            if ($dailyCount && $dailyCount->other_staff_count > $maxCount) {
                $maxCount = $dailyCount->other_staff_count;
            }
        }

        return $maxCount;
    }

    /**
     *  Increment leave count when approved
     */
    public static function incrementLeaveCount($leaveApplication)
    {
        $dates = $leaveApplication->getLeaveDates();
        $isCustomerSupport = $leaveApplication->user->isCustomerSupport();

        foreach ($dates as $date) {
            $dailyCount = self::getOrCreate($date);

            $dailyCount->total_count++;

            if ($isCustomerSupport) {
                $dailyCount->customer_support_count++;
            } else {
                $dailyCount->other_staff_count++;
            }

            $dailyCount->save();
        }
    }

    /**
     *  Decrement leave count when cancelled/rejected
     */
    public static function decrementLeaveCount($leaveApplication)
    {
        $dates = $leaveApplication->getLeaveDates();
        $isCustomerSupport = $leaveApplication->user->isCustomerSupport();

        foreach ($dates as $date) {
            $dailyCount = self::where('leave_date', $date)->first();

            if ($dailyCount) {
                $dailyCount->total_count = max(0, $dailyCount->total_count - 1);

                if ($isCustomerSupport) {
                    $dailyCount->customer_support_count = max(0, $dailyCount->customer_support_count - 1);
                } else {
                    $dailyCount->other_staff_count = max(0, $dailyCount->other_staff_count - 1);
                }

                $dailyCount->save();
            }
        }
    }
}
