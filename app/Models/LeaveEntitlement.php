<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEntitlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'annual_leave_total',
        'medical_leave_total',
        'annual_leave_used',
        'medical_leave_used',
    ];

    protected $casts = [
        'annual_leave_used' => 'decimal:1',
        'medical_leave_used' => 'decimal:1',
    ];

    /**
     * Relationship: Entitlement belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Annual Leave Balance
     */
    public function getAnnualLeaveBalanceAttribute()
    {
        return $this->annual_leave_total - $this->annual_leave_used;
    }

    /**
     * Get Medical Leave Balance
     */
    public function getMedicalLeaveBalanceAttribute()
    {
        return $this->medical_leave_total - $this->medical_leave_used;
    }

    /**
     * Check if user has enough AL balance
     */
    public function hasEnoughAnnualLeave($days)
    {
        return $this->annual_leave_balance >= $days;
    }

    /**
     * Check if user has enough MC balance
     */
    public function hasEnoughMedicalLeave($days)
    {
        return $this->medical_leave_balance >= $days;
    }

    /**
     * Deduct Annual Leave
     */
    public function deductAnnualLeave($days)
    {
        $this->annual_leave_used += $days;
        $this->save();
    }

    /**
     * Deduct Medical Leave
     */
    public function deductMedicalLeave($days)
    {
        $this->medical_leave_used += $days;
        $this->save();
    }

    /**
     * Restore Annual Leave (if application cancelled/rejected after approval)
     */
    public function restoreAnnualLeave($days)
    {
        $this->annual_leave_used = max(0, $this->annual_leave_used - $days);
        $this->save();
    }

    /**
     * Restore Medical Leave
     */
    public function restoreMedicalLeave($days)
    {
        $this->medical_leave_used = max(0, $this->medical_leave_used - $days);
        $this->save();
    }
}