<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\LeaveEntitlement;
use App\Models\DailyLeaveCount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    /**
     * Show leave dashboard (balance & recent applications)
     */
    public function index()
    {
        $user = Auth::user();

        //  INTERNS: Calculate TOTAL balance across ENTIRE internship period
        if ($user->role === 'intern' && $user->internship_start_date && $user->internship_end_date) {
            $startYear = \Carbon\Carbon::parse($user->internship_start_date)->year;
            $endYear = \Carbon\Carbon::parse($user->internship_end_date)->year;

            // Initialize totals
            $totalAnnualLeave = 0;
            $totalAnnualUsed = 0;
            $totalMedicalLeave = 0;
            $totalMedicalUsed = 0;

            //  FETCH existing entitlements WITHOUT creating new ones
            $existingEntitlements = \App\Models\LeaveEntitlement::where('user_id', $user->id)
                ->whereBetween('year', [$startYear, $endYear])
                ->get();

            // Sum up entitlements across all years
            foreach ($existingEntitlements as $yearEntitlement) {
                $totalAnnualLeave += $yearEntitlement->annual_leave_total;
                $totalAnnualUsed += $yearEntitlement->annual_leave_used;
                $totalMedicalLeave += $yearEntitlement->medical_leave_total;
                $totalMedicalUsed += $yearEntitlement->medical_leave_used;
            }

            // Create a virtual combined entitlement object for display
            $entitlement = (object)[
                'annual_leave_total' => $totalAnnualLeave,
                'annual_leave_used' => $totalAnnualUsed,
                'annual_leave_balance' => $totalAnnualLeave - $totalAnnualUsed,
                'medical_leave_total' => $totalMedicalLeave,
                'medical_leave_used' => $totalMedicalUsed,
                'medical_leave_balance' => $totalMedicalLeave - $totalMedicalUsed,
            ];
        } elseif (in_array($user->role, ['part_time', 'staff_ge'])) {
            // PART TIME & STAFF GE: No yearly limit — show usage only
            $entitlement = (object)[
                'annual_leave_total'   => 0,
                'annual_leave_used'    => LeaveApplication::where('user_id', $user->id)
                                            ->whereIn('status', ['approved', 'special_case_approved'])
                                            ->whereIn('leave_type', ['AL', 'HALF_DAY_AL'])
                                            ->sum('total_days'),
                'annual_leave_balance' => 999, // unlimited
                'medical_leave_total'  => 0,
                'medical_leave_used'   => LeaveApplication::where('user_id', $user->id)
                                            ->whereIn('status', ['approved', 'special_case_approved'])
                                            ->where('leave_type', 'MC')
                                            ->sum('total_days'),
                'medical_leave_balance'=> 999, // unlimited
            ];
        } else {
            //  STAFF/ADMIN/SUPERADMIN: Use current year only
            $year = date('Y');
            $entitlement = $user->getOrCreateEntitlement($year);
        }

        // Get recent applications (last 10)
        $recentApplications = LeaveApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get current month stats
        $currentMonth = date('m');
        $currentYear = date('Y');
        $currentMonthApplications = LeaveApplication::where('user_id', $user->id)
            ->forMonth($currentYear, $currentMonth)
            ->whereIn('status', ['approved', 'special_case_approved'])
            ->get();

        $alThisMonth = $currentMonthApplications->whereIn('leave_type', ['AL', 'EL', 'HALF_DAY_AL', 'HALF_DAY_EL'])->sum('total_days');
        $mcThisMonth = $currentMonthApplications->where('leave_type', 'MC')->sum('total_days');

        return view('leave.index', compact(
            'entitlement',
            'recentApplications',
            'alThisMonth',
            'mcThisMonth'
        ));
    }

    /**
     * Show apply leave form
     */
    public function create()
    {
        $user = Auth::user();

        //  BLOCK INTERNS WHO HAVEN'T SET DATES
        if ($user->role === 'intern') {
            if (!$user->internship_start_date || !$user->internship_end_date) {
                return redirect()->route('leave.index')
                    ->with('error', 'You must set your internship dates in your profile before applying for leave. Please go to My Profile → Edit Profile to set your start and end dates.');
            }

            //  ROUTE INTERNS TO THEIR SPECIFIC PAGE
            $entitlement = $user->getOrCreateEntitlement(date('Y'));
            return view('intern.apply-leave', compact('entitlement'));
        }

        //  STAFF/ADMIN/SUPERADMIN GET NORMAL PAGE
        $entitlement = $user->getOrCreateEntitlement(date('Y'));
        return view('leave.apply', compact('entitlement'));
    }

    /**
     * Store leave application
     */
/**
 * Store leave application
 */
public function store(Request $request)
{
    // Base validation rules
    $rules = [
        'leave_type' => 'required|in:AL,EL,MC,CL,WFH,ML,PL,RL,MRL,SL,HALF_DAY_AL,HALF_DAY_EL', //  ADD 'SL'
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:500',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ];

    // MC requires attachment
    if ($request->leave_type === 'MC') {
        $rules['attachment'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
    }

    // Half-day requires period selection
    if (in_array($request->leave_type, ['HALF_DAY_AL', 'HALF_DAY_EL'])) {
        $rules['half_day_period'] = 'required|in:AM,PM';
    }

    $messages = [
        'leave_type.required' => 'Please select leave type',
        'start_date.required' => 'Start date is required',
        'end_date.required' => 'End date is required',
        'end_date.after_or_equal' => 'End date must be after or equal to start date',
        'reason.required' => 'Reason is required',
        'attachment.required' => 'Medical certificate is required for MC',
        'attachment.mimes' => 'Attachment must be PDF, JPG, JPEG, or PNG',
        'attachment.max' => 'Attachment size must not exceed 2MB',
        'half_day_period.required' => 'Please select AM or PM for half-day leave',
    ];

    $request->validate($rules, $messages);

    $user = Auth::user();

    //  BLOCK INTERNS WHO HAVEN'T SET DATES
    if ($user->role === 'intern') {
        if (!$user->internship_start_date || !$user->internship_end_date) {
            return back()->with('error', 'You must set your internship dates in your profile before applying for leave. Please go to My Profile → Edit Profile to set your start and end dates.');
        }

        //  RESTRICT LEAVE TYPES FOR INTERNS
        $allowedInternTypes = ['AL', 'EL', 'HALF_DAY_AL', 'HALF_DAY_EL', 'MC', 'SL']; //  ADD 'SL'
        if (!in_array($request->leave_type, $allowedInternTypes)) {
            return back()->with('error', 'Interns can only apply for Annual Leave (AL), Emergency Leave (EL), Half Day Leave, Medical Leave (MC), or Special Leave (SL).');
        }


    }

    //  RESTRICT LEAVE TYPES FOR PART TIME (AL only)
    if ($user->role === 'part_time') {
        $allowedPartTimeTypes = ['AL', 'HALF_DAY_AL'];
        if (!in_array($request->leave_type, $allowedPartTimeTypes)) {
            return back()->with('error', 'Part Time staff can only apply for Annual Leave (AL) or Half Day AL.');
        }
    }

    //  RESTRICT LEAVE TYPES FOR STAFF GE (AL + MC only)
    if ($user->role === 'staff_ge') {
        $allowedStaffGeTypes = ['AL', 'HALF_DAY_AL', 'MC'];
        if (!in_array($request->leave_type, $allowedStaffGeTypes)) {
            return back()->with('error', 'Staff GE can only apply for Annual Leave (AL), Half Day AL, or Medical Leave (MC).');
        }
    }

    $entitlement = $user->getOrCreateEntitlement(date('Y'));

    // Check if half-day
    $isHalfDay = in_array($request->leave_type, ['HALF_DAY_AL', 'HALF_DAY_EL']);

    //  Single day leave types — force end_date = start_date
    $singleDayTypes = ['AL', 'EL', 'MC', 'WFH', 'RL', 'SL', 'HALF_DAY_AL', 'HALF_DAY_EL'];
    if (in_array($request->leave_type, $singleDayTypes)) {
        $request->merge(['end_date' => $request->start_date]);
    }

    // Calculate total days
    $totalDays = $isHalfDay ? 0.5 : LeaveApplication::calculateDays($request->start_date, $request->end_date);

    // VALIDATION 1: 7-day advance for AL/HALF_DAY_AL (STAFF ONLY - interns exempt)
    if (in_array($request->leave_type, ['AL', 'HALF_DAY_AL']) && $user->role !== 'intern') {
        $startDate = Carbon::parse($request->start_date);
        $today = Carbon::today();

        if ($startDate->lte($today)) {
            return back()->with('error', 'Annual Leave cannot be applied for past dates or today. Please apply at least 3 days in advance.');
        }

        $daysUntilLeave = $today->diffInDays($startDate, false);

        if ($daysUntilLeave < 2) {
            return back()->with('error', 'Annual Leave must be applied at least 2 days in advance. Plan accordingly.');
        }
    }

    // VALIDATION 2: Backdating check
    $startDate = Carbon::parse($request->start_date)->startOfDay();
    $today = Carbon::today('Asia/Kuala_Lumpur');

if ($startDate->lt($today)) {
    $leaveType = $request->leave_type;
    $backdatingAllowed = LeaveApplication::$backdatingAllowedTypes;

    if (!array_key_exists($leaveType, $backdatingAllowed)) {
        return back()->with('error', 'This leave type does not allow backdating.');
    }

    $maxBackdatingDays = $backdatingAllowed[$leaveType];

    // AL & HALF_DAY_AL — cannot backdate at all
    if ($maxBackdatingDays === 0) {
        return back()->with('error', 'Annual Leave cannot be backdated. Please apply at least 7 days in advance.');
    }

    $daysBack = $today->diffInDays($startDate);

    if ($daysBack > $maxBackdatingDays) {
        return back()->with('error', "This leave type can only be backdated up to {$maxBackdatingDays} days.");
    }
}

    // VALIDATION 3: Fixed days validation
    if ($request->leave_type === 'CL' && $totalDays != 3) {
        return back()->with('error', 'Compassionate Leave must be exactly 3 consecutive calendar days.');
    }








    if ($request->leave_type === 'MRL' && $totalDays != 3) {
        return back()->with('error', 'Married Leave must be exactly 3 consecutive calendar days.');
    }

    if ($request->leave_type === 'ML' && $totalDays > 98) {
        return back()->with('error', 'Maternity Leave cannot exceed 98 calendar days.');
    }

    if ($request->leave_type === 'PL' && $totalDays > 7) {
        return back()->with('error', 'Paternity Leave cannot exceed 7 calendar days.');
    }

    //  VALIDATION 3.5: Validate intern leave dates within internship period
    if ($user->role === 'intern') {
        $internStart = Carbon::parse($user->internship_start_date);
        $internEnd = Carbon::parse($user->internship_end_date);
        $leaveStart = Carbon::parse($request->start_date);
        $leaveEnd = Carbon::parse($request->end_date);

        if ($leaveStart->lt($internStart)) {
            return back()->with('error', 'Leave cannot start before your internship begins (' . $internStart->format('d/m/Y') . ')');
        }

        if ($leaveEnd->gt($internEnd)) {
            return back()->with('error', 'Leave cannot extend beyond your internship end date (' . $internEnd->format('d/m/Y') . ')');
        }
    }

    //  NOTE: Special Leave (SL) has NO balance check - automatically skipped below
    // SL is in $unCountedLeaveTypes, so balance validation won't run for it

    // VALIDATION 4: Check balance (skip for part_time & staff_ge — tiada limit)
    if (!in_array($user->role, ['part_time', 'staff_ge'])) {
        if (in_array($request->leave_type, ['AL', 'HALF_DAY_AL'])) {
            if (!$entitlement->hasEnoughAnnualLeave($totalDays)) {
                return back()->with('error', 'Insufficient Annual Leave balance. You only have ' . $entitlement->annual_leave_balance . ' days left.');
            }
        } else if ($request->leave_type === 'EL' || $request->leave_type === 'HALF_DAY_EL') {
            if (!$entitlement->hasEnoughAnnualLeave($totalDays)) {
                return back()->with('error', 'Insufficient Emergency Leave balance. You only have ' . $entitlement->annual_leave_balance . ' days left.');
            }
        } else if ($request->leave_type === 'MC') {
            if (!$entitlement->hasEnoughMedicalLeave($totalDays)) {
                return back()->with('error', 'Insufficient Medical Leave balance. You only have ' . $entitlement->medical_leave_balance . ' days left.');
            }
        }
    }

    // VALIDATION 5: Check daily limit and determine status
    $tempApplication = new LeaveApplication([
        'user_id' => $user->id,
        'leave_type' => $request->leave_type,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_days' => $totalDays,
    ]);
    $tempApplication->setRelation('user', $user);

    $initialStatus = 'pending';

    // Check if exempt from daily limit
    if (!$tempApplication->isExemptFromDailyLimit()) {
        $dates = $tempApplication->getLeaveDates();
        $maxTotalCount = 0;

        foreach ($dates as $date) {
            $dailyCount = DailyLeaveCount::where('leave_date', $date)->first();
            $approvedCount = $dailyCount ? $dailyCount->other_staff_count : 0;

            $pendingCount = LeaveApplication::where('status', 'pending')
                ->where('user_id', '!=', $user->id)
                ->where('leave_type', '!=', 'ML')
                ->where('leave_type', '!=', 'PL')
                ->where(function($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                          ->where('end_date', '>=', $date);
                })
                ->whereHas('user', function($query) {
                $query->whereNotIn('position', [
                    'Customer Support Engineer',
                    'Lead Customer Support Engineer'
                ])
                ->whereNotIn('role', ['part_time', 'staff_ge']);
            })
            ->count();



            $totalCount = $approvedCount + $pendingCount;

            if ($totalCount > $maxTotalCount) {
                $maxTotalCount = $totalCount;
            }
        }

        if ($maxTotalCount >= 2) {
            $initialStatus = 'waiting_list';
        }
    }

    // Handle file upload
    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $sanitizedFilename = time() . '_' . $user->id . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
        $attachmentPath = $file->storeAs('leave_attachments', $sanitizedFilename, 'public');
    }

    // Create leave application
    LeaveApplication::create([
        'user_id' => $user->id,
        'leave_type' => $request->leave_type,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_days' => $totalDays,
        'is_half_day' => $isHalfDay,
        'half_day_period' => $isHalfDay ? $request->half_day_period : null,
        'reason' => $request->reason,
        'attachment' => $attachmentPath,
        'status' => $initialStatus,
    ]);

    if ($initialStatus === 'waiting_list') {
        return redirect()->route('leave.index')->with('warning', 'Maximum 2 staff already approved/pending for selected date(s). Your application is on WAITING LIST. Please meet with Admin (Ramyan) ASAP for special case approval.');
    }

    return redirect()->route('leave.index')->with('success', 'Leave application submitted successfully! Waiting for Admin approval.');
}

    /**
     * Show all user's leave applications
     */
    public function myApplications()
    {
        $user = Auth::user();

        $applications = LeaveApplication::where('user_id', $user->id)
            ->with(['approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('leave.my-applications', compact('applications'));
    }

    /**
     * Show single leave application details
     */
    public function show($id)
    {
        $application = LeaveApplication::where('user_id', Auth::id())
            ->with(['approvedBy'])
            ->findOrFail($id);

        return view('leave.show', compact('application'));
    }

    /**
     * Cancel PENDING/WAITING_LIST leave application (with cascade logic)
     */
    public function cancel($id)
    {
        $application = LeaveApplication::where('user_id', Auth::id())
            ->findOrFail($id);

        if (!in_array($application->status, ['pending', 'waiting_list', 'rejected'])) {
            return back()->with('error', 'Only pending, waiting list or rejected applications can be cancelled.');
        }

        //  Block staff/intern from cancelling if leave has started or passed
        // (skip this check for rejected — no date restriction for cancelling rejected)
        if (!in_array($application->status, ['rejected'])) {
            if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                $today = Carbon::today('Asia/Kuala_Lumpur');
                $startDate = Carbon::parse($application->start_date);

                if ($startDate->lte($today)) {
                    return back()->with('error', 'You cannot cancel a leave that has already started or passed. Please contact Admin if needed.');
                }
            }
        }

        $originalStatus = $application->status;

        // Mark as cancelled
            $application->update([
            'status' => 'cancelled',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        //  If PENDING was cancelled, check if we should promote waiting list
        // (rejected apps skip cascade — they were never in the queue)
        if ($originalStatus === 'pending' && !$application->isExemptFromDailyLimit()) {
            $dates = $application->getLeaveDates();

            foreach ($dates as $date) {
                $dailyCount = DailyLeaveCount::where('leave_date', $date)->first();
                $approvedCount = $dailyCount ? $dailyCount->other_staff_count : 0;

                // Count remaining pending (after this cancellation)
                $pendingCount = LeaveApplication::where('status', 'pending')
                    ->where('id', '!=', $application->id)
                    ->where('leave_type', '!=', 'ML')
                    ->where('leave_type', '!=', 'PL')
                    ->where(function($query) use ($date) {
                        $query->where('start_date', '<=', $date)
                            ->where('end_date', '>=', $date);
                    })
                    ->whereHas('user', function($query) {
                        $query->whereNotIn('position', [
                            'Customer Support Engineer',
                            'Lead Customer Support Engineer'
                        ]);
                    })
                    ->count();

                $totalCount = $approvedCount + $pendingCount;

                //  If total < 2, promote next waiting list
                if ($totalCount < 2) {
                    $waitingApp = LeaveApplication::where('status', 'waiting_list')
                        ->where(function($query) use ($date) {
                            $query->where('start_date', '<=', $date)
                                ->where('end_date', '>=', $date);
                        })
                        ->orderBy('created_at', 'asc')
                        ->first();

                    if ($waitingApp) {
                        $waitingApp->update(['status' => 'pending']);

                        return back()->with('success', "Leave cancelled successfully! 🎉 Good news: {$waitingApp->user->name}'s application moved from Waiting List to Pending.");
                    }
                }
            }
        }

        return back()->with('success', 'Leave application cancelled successfully.');
    }

    /**
     * Cancel APPROVED leave (triggers cascading logic)
     */
    public function cancelApproved($id)
    {
        $application = LeaveApplication::where('user_id', Auth::id())
            ->findOrFail($id);

        if (!in_array($application->status, ['approved', 'special_case_approved'])) {
            return back()->with('error', 'This application cannot be cancelled.');
        }

        //  Block staff/intern from cancelling if leave has started or passed
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            $today = Carbon::today('Asia/Kuala_Lumpur');
            $startDate = Carbon::parse($application->start_date);

            if ($startDate->lte($today)) {
                return back()->with('error', 'You cannot cancel a leave that has already started or passed. Please contact Admin if needed.');
            }
        }

        DB::beginTransaction();

        try {
            $originalStatus = $application->status;

            // Restore balance if applicable
            if ($application->requiresBalanceCheck()) {
                $year = date('Y', strtotime($application->start_date));
                $entitlement = $application->user->getOrCreateEntitlement($year);

                if (in_array($application->leave_type, ['AL', 'EL', 'HALF_DAY_AL', 'HALF_DAY_EL'])) {
                    $entitlement->restoreAnnualLeave($application->total_days);
                } else if ($application->leave_type === 'MC') {
                    $entitlement->restoreMedicalLeave($application->total_days);
                }
            }

            // Decrement daily count
            DailyLeaveCount::decrementLeaveCount($application);

            // Mark as cancelled
            $application->update([
                'status' => 'cancelled',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            //  CASCADE: Only if APPROVED (not special_case_approved)
            if ($originalStatus === 'approved') {
                $dates = $application->getLeaveDates();
                $currentCount = DailyLeaveCount::getCurrentCountForDates($dates);

                if ($currentCount < 2) {
                    $waitingListApps = LeaveApplication::where('status', 'waiting_list')
                        ->where(function($query) use ($dates) {
                            foreach ($dates as $date) {
                                $query->orWhere(function($q) use ($date) {
                                    $q->where('start_date', '<=', $date)
                                    ->where('end_date', '>=', $date);
                                });
                            }
                        })
                        ->orderBy('created_at', 'asc')
                        ->get();

                    if ($waitingListApps->isNotEmpty()) {
                        $nextApp = $waitingListApps->first();
                        $nextApp->update(['status' => 'pending']);

                        $nextStaffName = $nextApp->user->name;

                        DB::commit();

                        return back()->with('success', "Leave cancelled successfully! 🎉 Good news: {$nextStaffName}'s application moved from Waiting List to Pending.");
                    }
                }
            }

            DB::commit();

            return back()->with('success', 'Leave cancelled successfully. Balance restored.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error cancelling leave: ' . $e->getMessage());
        }
    }

    /**
     * Download attachment
     */
    public function downloadAttachment($id)
    {
        $application = LeaveApplication::where('user_id', Auth::id())
            ->findOrFail($id);

        if (!$application->attachment) {
            return back()->with('error', 'No attachment found.');
        }

        return Storage::disk('public')->download($application->attachment);
    }

    /**
     *  Check daily leave limit for selected dates (AJAX)
     */
    public function checkDailyLimit(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $leaveType = $request->leave_type;

        $tempApplication = new LeaveApplication([
            'user_id' => $user->id,
            'leave_type' => $leaveType,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => LeaveApplication::calculateDays($startDate, $endDate),
        ]);
        $tempApplication->setRelation('user', $user);

        if ($tempApplication->isExemptFromDailyLimit()) {
            return response()->json([
                'hasLimit' => false,
                'isExempt' => true,
            ]);
        }

        $dates = $tempApplication->getLeaveDates();
        $maxApprovedCount = 0;
        $maxPendingCount = 0;
        $maxWaitingCount = 0;
        $affectedDates = [];

        foreach ($dates as $date) {
            $dailyCount = DailyLeaveCount::where('leave_date', $date)->first();
            $approvedCount = $dailyCount ? $dailyCount->other_staff_count : 0;

            $pendingCount = LeaveApplication::where('status', 'pending')
                ->where('user_id', '!=', $user->id)
                ->where('leave_type', '!=', 'ML')
                ->where('leave_type', '!=', 'PL')
                ->where(function($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                          ->where('end_date', '>=', $date);
                })
                ->whereHas('user', function($query) {
                    $query->whereNotIn('position', [
                        'Customer Support Engineer',
                        'Lead Customer Support Engineer'
                    ])
                    ->whereNotIn('role', ['part_time', 'staff_ge']);
                })
                ->count();

            $waitingCount = LeaveApplication::where('status', 'waiting_list')
                ->where('user_id', '!=', $user->id)
                ->where('leave_type', '!=', 'ML')
                ->where('leave_type', '!=', 'PL')
                ->where(function($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                          ->where('end_date', '>=', $date);
                })
                ->whereHas('user', function($query) {
                    $query->whereNotIn('position', [
                        'Customer Support Engineer',
                        'Lead Customer Support Engineer'
                    ])
                    ->whereNotIn('role', ['part_time', 'staff_ge']);
                })
                ->count();

            if ($approvedCount > 0 || $pendingCount > 0 || $waitingCount > 0) {
                $affectedDates[] = Carbon::parse($date)->format('d/m/Y');
            }

            if ($approvedCount > $maxApprovedCount) {
                $maxApprovedCount = $approvedCount;
            }

            if ($pendingCount > $maxPendingCount) {
                $maxPendingCount = $pendingCount;
            }

            if ($waitingCount > $maxWaitingCount) {
                $maxWaitingCount = $waitingCount;
            }
        }

        $totalCount = $maxApprovedCount + $maxPendingCount + $maxWaitingCount;
        $position = $totalCount + 1;

        $willBeWaitingList = ($maxApprovedCount + $maxPendingCount) >= 2;

        $suffix = 'th';
        if ($position == 1) $suffix = 'st';
        else if ($position == 2) $suffix = 'nd';
        else if ($position == 3) $suffix = 'rd';

        return response()->json([
            'hasLimit' => $totalCount > 0 || $willBeWaitingList,
            'approvedCount' => $maxApprovedCount,
            'pendingCount' => $maxPendingCount,
            'waitingCount' => $maxWaitingCount,
            'totalCount' => $totalCount,
            'willBeWaitingList' => $willBeWaitingList,
            'position' => $position . $suffix,
            'affectedDates' => $affectedDates,
        ]);
    }
}
