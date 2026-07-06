<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\LeaveEntitlement;
use App\Models\DailyLeaveCount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminLeaveController extends Controller
{
    /**
     * Show admin leave dashboard
     */
    public function index()
    {
        $currentYear = date('Y');

        // Stats
        $pendingCount = LeaveApplication::pending()->count();
        $waitingListCount = LeaveApplication::waitingList()->count();
        $approvedThisMonth = LeaveApplication::whereIn('status', ['approved', 'special_case_approved'])
            ->whereYear('start_date', $currentYear)
            ->whereMonth('start_date', date('m'))
            ->count();
        $totalApplications = LeaveApplication::whereYear('created_at', $currentYear)->count();

        // Recent applications
        $recentApplications = LeaveApplication::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.leave.index', compact(
            'pendingCount',
            'waitingListCount',
            'approvedThisMonth',
            'totalApplications',
            'recentApplications'
        ));
    }

    /**
     * Show pending applications (waiting for admin approval)
     *  UPDATED: Show all results without pagination
     */
    public function pendingApplications()
    {
        $pendingApplications = LeaveApplication::with('user')
            ->pending()
            ->orderBy('created_at', 'asc')
            ->get(); //  Changed from paginate(20) to get()

        return view('admin.leave.pending', compact('pendingApplications'));
    }

    /**
     * Show all leave applications
     */
    public function allApplications(Request $request)
    {
        // Start query with relationships
        $query = LeaveApplication::with(['user', 'approvedBy'])
            ->orderBy('created_at', 'desc');

        // NEW FILTER - Search by staff name
        if ($request->filled('staff_name')) {
            $searchTerm = $request->staff_name;
            $query->whereHas('user', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by leave type
        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        // Filter by year
        $year = $request->filled('year') ? $request->year : date('Y');
        $query->whereYear('start_date', $year);

       $applications = $query->orderBy('created_at', 'desc')
       ->get();

        return view('admin.leave.all-applications', compact('applications'));
    }

    /**
     * Show leave applications grouped by date
     */
    public function leaveByDate(Request $request)
    {
        // Get filter inputs
        $month = $request->filled('month') ? $request->month : date('m');
        $year = $request->filled('year') ? $request->year : date('Y');
        $status = $request->filled('status') ? $request->status : null;

        // Build base query
        $query = LeaveApplication::with(['user', 'approvedBy'])
            ->whereYear('start_date', $year)
            ->whereMonth('start_date', $month);

        // Filter by status if selected
        if ($status) {
            $query->where('status', $status);
        }

        // Get all applications
        $applications = $query->get();

        // Get all unique dates from applications
        $uniqueDates = [];

        foreach ($applications as $application) {
        $dates = $application->getLeaveDates();

            foreach ($dates as $date) {
                $dateCarbon = Carbon::parse($date);
                if ($dateCarbon->month != $month || $dateCarbon->year != $year) {
                    continue;
                }

                if (!isset($uniqueDates[$date])) {
                    $uniqueDates[$date] = [];
                }

                //  Check duplicate — jangan masuk kalau ID sama dah ada
                $existingIds = array_column(
                    array_map(fn($a) => ['id' => $a->id], $uniqueDates[$date]),
                    'id'
                );

                if (!in_array($application->id, $existingIds)) {
                    $uniqueDates[$date][] = $application;
                }
            }
        }

        // Sort dates chronologically
        ksort($uniqueDates);

        // For each date, sort applications by created_at (who applied first)
        // KEPADA INI (tanpa & reference):
        foreach ($uniqueDates as $date => $apps) {
            usort($uniqueDates[$date], function($a, $b) {
                return $a->created_at <=> $b->created_at;
            });
        }

        //  FIXED: Calculate stats for each date
        $dateStats = [];
        foreach ($uniqueDates as $date => $apps) {
            $allApps = collect($apps);

            //  For LIMIT calculation: Only count non-exempt staff (exclude CSE & ML/PL)
            $countableApps = $allApps->filter(function($app) {
                if (in_array($app->leave_type, ['ML', 'PL'])) {
                    return false;
                }
                if ($app->user && $app->user->isCustomerSupport()) {
                    return false;
                }
                if ($app->user && in_array($app->user->role, ['part_time', 'staff_ge'])) {
                    return false;
                }
                return true;
            });

            //  For BADGE display: Count ALL applications (including CSE)
            $allPending = $allApps->where('status', 'pending')->count();
            $allWaiting = $allApps->where('status', 'waiting_list')->count();

            //  For LIMIT indicator: Count only non-exempt approved
            $approved = $countableApps->where('status', 'approved')->count();
            $specialCase = $countableApps->where('status', 'special_case_approved')->count();
            $totalApproved = $approved + $specialCase;

            //  Color based on ACTUAL countable staff only
            $statusColor = 'success'; // Green (0-1 people)
            if ($totalApproved >= 3) {
                $statusColor = 'danger'; // Red (3+ people - over limit)
            } elseif ($totalApproved >= 2) {
                $statusColor = 'warning'; // Orange (2 people - at limit)
            }

            $dateStats[$date] = [
                'approved' => $approved,
                'special_case' => $specialCase,
                'pending' => $allPending,  //  ALL pending (including CSE)
                'waiting_list' => $allWaiting,  //  ALL waiting (including CSE)
                'total_approved' => $totalApproved,
                'status_color' => $statusColor,
            ];
        }

        return view('admin.leave.by-date', compact('uniqueDates', 'dateStats', 'month', 'year', 'status'));
    }

    /**
     * Show single application details
     */
    public function show($id)
    {
        $application = LeaveApplication::with('user', 'approvedBy')
            ->findOrFail($id);

        return view('admin.leave.show', compact('application'));
    }

    /**
     * Approve leave application (ADMIN APPROVAL) -  UPDATED WITH AUTO-MOVE LOGIC
     */
    public function approve($id)
    {
        $application = LeaveApplication::with('user')->findOrFail($id);

        // Check if already processed
        if (!in_array($application->status, ['pending', 'waiting_list'])) {
            return back()->with('error', 'This application has already been processed.');
        }

        //  STEP 0: Validate approval_note for Special Leave (MANDATORY)
        if ($application->leave_type === 'SL') {
            request()->validate([
                'approval_note' => 'required|string|max:500',
            ], [
                'approval_note.required' => 'Approval remark is MANDATORY for Special Leave.',
                'approval_note.max' => 'Approval remark cannot exceed 500 characters.',
            ]);
        }

        DB::beginTransaction();

        try {
            // STEP 1: Validate fixed day requirements
            if ($application->leave_type === 'CL' && $application->total_days != 3) {
                DB::rollBack();
                return back()->with('error', 'Compassionate Leave must be exactly 3 consecutive calendar days.');
            }

            if ($application->leave_type === 'MRL' && $application->total_days != 3) {
                DB::rollBack();
                return back()->with('error', 'Married Leave must be exactly 3 consecutive calendar days.');
            }

            if ($application->leave_type === 'ML' && $application->total_days > 98) {
                DB::rollBack();
                return back()->with('error', 'Maternity Leave cannot exceed 98 calendar days.');
            }

            if ($application->leave_type === 'PL' && $application->total_days > 7) {
                DB::rollBack();
                return back()->with('error', 'Paternity Leave cannot exceed 7 calendar days.');
            }

            // STEP 2: Check daily leave limits (for non-exempt types)
            $approvalStatus = 'approved';

            //  WARNING: part_time & staff_ge exempt dari limit, tapi tunjuk warning kalau dah 2 orang approved
            if ($application->user->isExemptFromDailyLimit() && !in_array($application->leave_type, ['ML', 'PL'])) {
                $limitCheck = DailyLeaveCount::canApproveLeave($application);
                if (!$limitCheck['canApprove']) {
                    // Simpan flag untuk warning — tapi tetap proceed approve
                    session(['leave_limit_warning' => true]);
                }
            }

            if (!$application->isExemptFromDailyLimit()) {
                $limitCheck = DailyLeaveCount::canApproveLeave($application);

                // If limit reached and status is pending (not waiting_list)
                if (!$limitCheck['canApprove'] && $application->status === 'pending') {
                    DB::rollBack();
                    return back()->with('error', $limitCheck['message'] . ' Cannot approve as normal leave. Staff must be on waiting list first.');
                }

                // If status is waiting_list, approve as special_case_approved
                if ($application->status === 'waiting_list') {
                    $approvalStatus = 'special_case_approved';
                }
            }

            // STEP 3: Check and deduct balance (only for counted types)
            if ($application->requiresBalanceCheck()) {
                $year = date('Y', strtotime($application->start_date));
                $entitlement = $application->user->getOrCreateEntitlement($year);

                if (in_array($application->leave_type, ['AL', 'EL', 'HALF_DAY_AL', 'HALF_DAY_EL'])) {
                    if (!$entitlement->hasEnoughAnnualLeave($application->total_days)) {
                        DB::rollBack();
                        return back()->with('error', 'Insufficient Annual/Emergency Leave balance.');
                    }
                    $entitlement->deductAnnualLeave($application->total_days);

                } else if ($application->leave_type === 'MC') {
                    if (!$entitlement->hasEnoughMedicalLeave($application->total_days)) {
                        DB::rollBack();
                        return back()->with('error', 'Insufficient Medical Leave balance.');
                    }
                    $entitlement->deductMedicalLeave($application->total_days);
                }
            }

            // STEP 4: Increment daily leave counts
            DailyLeaveCount::incrementLeaveCount($application);

            // STEP 5: Update application status
            $application->update([
                'status' => $approvalStatus,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'approval_note' => $application->leave_type === 'SL' ? request('approval_note') : null, //  ADD THIS
            ]);

            //  NEW STEP 6: Auto-move other PENDING to WAITING_LIST if daily limit reached
            if (!$application->isExemptFromDailyLimit() && $approvalStatus === 'approved') {
                $this->autoMoveToWaitingList($application);
            }

            DB::commit();

            if ($approvalStatus === 'special_case_approved') {
                return back()->with('success', 'Leave application approved as SPECIAL CASE! (3rd person on this date)');
            }

            if (session('leave_limit_warning')) {
                session()->forget('leave_limit_warning');
                return back()->with('success', 'Leave application approved successfully!')
                            ->with('limit_warning', 'Warning: There are already 2 staff approved for this date. This user has been approved as exempt (Part Time / Staff GE).');
            }

            return back()->with('success', 'Leave application approved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error approving application: ' . $e->getMessage());
        }
    }

    /**
     *  FIXED: Auto-move PENDING applications to WAITING_LIST when limit reached
     * Now correctly includes BOTH staff and intern (max 2 total per day)
     */
    private function autoMoveToWaitingList($approvedApplication)
    {
        // Get all dates covered by the approved application
        $dates = $approvedApplication->getLeaveDates();

        // For each date, check if daily count reached 2
        foreach ($dates as $date) {
            $dailyCount = DailyLeaveCount::where('leave_date', $date)->first();

            //  If other_staff_count (staff + intern combined) reached 2, move all other PENDING to WAITING_LIST
            if ($dailyCount && $dailyCount->other_staff_count >= 2) {
                // Find all PENDING applications that overlap with this date (excluding approved one)
                LeaveApplication::where('status', 'pending')
                    ->where('id', '!=', $approvedApplication->id)
                    ->whereNotIn('leave_type', ['ML', 'PL']) //  ADDED: Exclude exempt leave types
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
                    ->update([
                        'status' => 'waiting_list',
                        'updated_at' => now()
                    ]);
            }
        }
    }

/**
 * Reject leave application (Admin only)
 */
public function reject($id)
{
    $application = LeaveApplication::with('user')->findOrFail($id);

    // Only reject pending or waiting_list
    if (!in_array($application->status, ['pending', 'waiting_list'])) {
        return back()->with('error', 'Only pending or waiting list applications can be rejected.');
    }

    $originalStatus = $application->status;

    // Update to rejected — no balance restore needed (never deducted)
    $application->update([
        'status'          => 'rejected',
        'approved_by'     => Auth::id(),
        'approved_at'     => now(),
        'rejection_reason'=> null,
    ]);

    // Cascade logic — same as cancel pending
    // If rejected was PENDING, check if we should promote waiting_list
    if ($originalStatus === 'pending' && !$application->isExemptFromDailyLimit()) {
        $dates = $application->getLeaveDates();

        foreach ($dates as $date) {
            $dailyCount   = DailyLeaveCount::where('leave_date', $date)->first();
            $approvedCount = $dailyCount ? $dailyCount->other_staff_count : 0;

            // Count remaining pending after this rejection
            $pendingCount = LeaveApplication::where('status', 'pending')
                ->where('id', '!=', $application->id)
                ->whereNotIn('leave_type', ['ML', 'PL'])
                ->where(function ($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                          ->where('end_date', '>=', $date);
                })
                ->whereHas('user', function ($query) {
                    $query->whereNotIn('position', [
                        'Customer Support Engineer',
                        'Lead Customer Support Engineer'
                    ])
                    ->whereNotIn('role', ['part_time', 'staff_ge']);
                })
                ->count();

            $totalCount = $approvedCount + $pendingCount;

            // If slot available, promote next waiting_list
            if ($totalCount < 2) {
                $waitingApp = LeaveApplication::where('status', 'waiting_list')
                    ->where(function ($query) use ($date) {
                        $query->where('start_date', '<=', $date)
                              ->where('end_date', '>=', $date);
                    })
                    ->orderBy('created_at', 'asc')
                    ->first();

                if ($waitingApp) {
                    $waitingApp->update(['status' => 'pending']);

                    return back()->with('success', "Application rejected. {$waitingApp->user->name}'s application moved from Waiting List to Pending.");
                }
            }
        }
    }

    return back()->with('success', 'Leave application rejected successfully.');
}

    /**
     * Cancel approved leave (Admin can cancel on behalf of staff)
     */
    public function cancelApproved($id)
    {
        $application = LeaveApplication::findOrFail($id);

        // Can only cancel approved or special_case_approved
        if (!in_array($application->status, ['approved', 'special_case_approved'])) {
            return back()->with('error', 'This application cannot be cancelled.');
        }

        DB::beginTransaction();

        try {
            //  IMPORTANT: Store original status BEFORE cancelling
            $originalStatus = $application->status; // 'approved' or 'special_case_approved'

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

            //  NEW LOGIC: Only cascade if APPROVED (not special_case_approved)
            if ($originalStatus === 'approved') {
                // CASCADING LOGIC: Move next waiting_list to pending
                $dates = $application->getLeaveDates();

                // Get current count after decrement
                $currentCount = DailyLeaveCount::getCurrentCountForDates($dates);

                //  Only cascade if count < 2 (one slot available)
                if ($currentCount < 2) {
                    // Find waiting_list applications for same dates
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

                    // Move first waiting list to pending
                    if ($waitingListApps->isNotEmpty()) {
                        $nextApp = $waitingListApps->first();
                        $nextApp->update(['status' => 'pending']);

                        // Get the staff name for better message
                        $nextStaffName = $nextApp->user->name;

                        DB::commit();

                        return back()->with('success', "Leave cancelled successfully! 🎉 Good news: {$nextStaffName}'s application moved from Waiting List to Pending.");
                    }
                }
            }

            //  If special_case_approved OR no waiting list OR still at limit
            DB::commit();

            return back()->with('success', 'Leave cancelled successfully. Balance restored.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error cancelling leave: ' . $e->getMessage());
        }
    }

    /**
     * Show staff leave entitlements (EXCLUDE INTERNS)
     */
    public function staffEntitlements(Request $request)
    {
        $year = $request->filled('year') ? $request->year : date('Y');

        //  Define position hierarchy (from top to bottom)
        $positionOrder = [
            'Project/Operation Manager',
            'Assistant Operation Manager',
            'Lead Customer Support Engineer',
            'Customer Support Engineer',
            'Lead Application Support Engineer',
            'Application Support Engineer',
            'Lead Technical Support Engineer',
            'Technical Support Engineer',
            'Lead System Support Engineer',
            'System Support Engineer',
            'Database Administrator',
            'Lead Network & Security Support Engineer',
            'Network & Security Support Engineer',
        ];

        // Get all staff
        $staff = User::where('status', 'active')
            ->whereIn('role', ['staff', 'admin', 'superadmin']) //  Include superadmin
            ->with(['leaveEntitlements' => function($query) use ($year) {
                $query->where('year', $year);
            }])
            ->get();

        // Get or create entitlements
        foreach ($staff as $member) {
            if (!$member->leaveEntitlements->first()) {
                $member->getOrCreateEntitlement($year);
            }
        }

        //  Custom sort by position hierarchy, then by name
        $staff = $staff->sortBy(function($member) use ($positionOrder) {
            $position = $member->position;
            $orderIndex = array_search($position, $positionOrder);

            // If position not in list, put at end
            if ($orderIndex === false) {
                $orderIndex = 999;
            }

            // Return: [position_order, name] for sorting
            return [$orderIndex, $member->name];
        })->values(); // Reset collection keys

        return view('admin.leave.staff-entitlements', compact('staff', 'year'));
    }
    /**
     * Show intern leave entitlements (SEPARATE PAGE)
     */
    public function internEntitlements()
    {
        // Get all active interns with their entitlements
        $interns = User::where('status', 'active')
            ->where('role', 'intern')
            ->with(['leaveEntitlements'])
            ->orderBy('name', 'asc')
            ->get();

        // Calculate entitlement for each intern based on their internship start year
        foreach ($interns as $intern) {
            if ($intern->internship_start_date) {
                $year = \Carbon\Carbon::parse($intern->internship_start_date)->year;
                $intern->entitlement = $intern->getOrCreateEntitlement($year);
            }
        }

        return view('admin.leave.intern-entitlements', compact('interns'));
    }

    /**
     * Show apply leave for staff form (Admin only)
     */
    public function applyForStaff()
    {
        $staff = User::where('status', 'active')
            ->whereIn('role', ['staff', 'admin', 'superadmin', 'intern', 'part_time', 'staff_ge'])
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.leave.apply-for-staff', compact('staff'));
    }

    /**
     * Store leave application on behalf of staff (Admin only)
     */
    public function storeForStaff(Request $request)
    {
        $rules = [
            'user_id'    => 'required|exists:users,id',
            'leave_type' => 'required|in:AL,EL,MC,CL,WFH,ML,PL,RL,MRL,SL,HALF_DAY_AL,HALF_DAY_EL',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'required|string|max:500',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        if ($request->leave_type === 'MC') {
            $rules['attachment'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if (in_array($request->leave_type, ['HALF_DAY_AL', 'HALF_DAY_EL'])) {
            $rules['half_day_period'] = 'required|in:AM,PM';
        }

        // SL requires approval note
        if ($request->leave_type === 'SL') {
            $rules['approval_note'] = 'required|string|max:500';
        }

        $request->validate($rules, [
            'user_id.required'       => 'Please select a staff member.',
            'leave_type.required'    => 'Please select leave type.',
            'start_date.required'    => 'Start date is required.',
            'end_date.required'      => 'End date is required.',
            'reason.required'        => 'Reason is required.',
            'attachment.required'    => 'Medical certificate is required for MC.',
            'half_day_period.required'=> 'Please select AM or PM for half-day leave.',
            'approval_note.required' => 'Approval remark is mandatory for Special Leave.',
        ]);

        $targetUser = User::findOrFail($request->user_id);

        //  Validate leave type allowed for role
        if ($targetUser->role === 'intern') {
            $allowed = ['AL', 'EL', 'HALF_DAY_AL', 'HALF_DAY_EL', 'MC', 'SL'];
            if (!in_array($request->leave_type, $allowed)) {
                return back()->with('error', 'Interns can only apply for AL, EL, Half Day, MC, or SL.')->withInput();
            }
        }

        if ($targetUser->role === 'part_time') {
            $allowed = ['AL', 'HALF_DAY_AL'];
            if (!in_array($request->leave_type, $allowed)) {
                return back()->with('error', 'Part Time staff can only apply for AL or Half Day AL.')->withInput();
            }
        }

        if ($targetUser->role === 'staff_ge') {
            $allowed = ['AL', 'HALF_DAY_AL', 'MC'];
            if (!in_array($request->leave_type, $allowed)) {
                return back()->with('error', 'Staff GE can only apply for AL, Half Day AL, or MC.')->withInput();
            }
        }

        //  Force single day types
        $singleDayTypes = ['AL', 'EL', 'MC', 'WFH', 'RL', 'SL', 'HALF_DAY_AL', 'HALF_DAY_EL'];
        if (in_array($request->leave_type, $singleDayTypes)) {
            $request->merge(['end_date' => $request->start_date]);
        }

        $isHalfDay = in_array($request->leave_type, ['HALF_DAY_AL', 'HALF_DAY_EL']);
        $totalDays = $isHalfDay ? 0.5 : LeaveApplication::calculateDays($request->start_date, $request->end_date);

        //  Validate intern leave within internship period
        if ($targetUser->role === 'intern') {
            if (!$targetUser->internship_start_date || !$targetUser->internship_end_date) {
                return back()->with('error', 'This intern has not set internship dates yet.')->withInput();
            }

            $internStart = Carbon::parse($targetUser->internship_start_date);
            $internEnd   = Carbon::parse($targetUser->internship_end_date);
            $leaveStart  = Carbon::parse($request->start_date);
            $leaveEnd    = Carbon::parse($request->end_date);

            if ($leaveStart->lt($internStart)) {
                return back()->with('error', 'Leave cannot start before internship begins (' . $internStart->format('d/m/Y') . ').')->withInput();
            }
            if ($leaveEnd->gt($internEnd)) {
                return back()->with('error', 'Leave cannot extend beyond internship end date (' . $internEnd->format('d/m/Y') . ').')->withInput();
            }
        }

        //  Fixed days validation
        if ($request->leave_type === 'CL' && $totalDays != 3) {
            return back()->with('error', 'Compassionate Leave must be exactly 3 consecutive calendar days.')->withInput();
        }
        if ($request->leave_type === 'MRL' && $totalDays != 3) {
            return back()->with('error', 'Married Leave must be exactly 3 consecutive calendar days.')->withInput();
        }
        if ($request->leave_type === 'ML' && $totalDays > 98) {
            return back()->with('error', 'Maternity Leave cannot exceed 98 calendar days.')->withInput();
        }
        if ($request->leave_type === 'PL' && $totalDays > 7) {
            return back()->with('error', 'Paternity Leave cannot exceed 7 calendar days.')->withInput();
        }

        //  Balance check (skip part_time & staff_ge)
        if (!in_array($targetUser->role, ['part_time', 'staff_ge'])) {
            $year = Carbon::parse($request->start_date)->year;
            $entitlement = $targetUser->getOrCreateEntitlement($year);

            if (in_array($request->leave_type, ['AL', 'EL', 'HALF_DAY_AL', 'HALF_DAY_EL'])) {
                if (!$entitlement->hasEnoughAnnualLeave($totalDays)) {
                    return back()->with('error', 'Insufficient Annual Leave balance. Staff only has ' . $entitlement->annual_leave_balance . ' days left.')->withInput();
                }
            } elseif ($request->leave_type === 'MC') {
                if (!$entitlement->hasEnoughMedicalLeave($totalDays)) {
                    return back()->with('error', 'Insufficient Medical Leave balance. Staff only has ' . $entitlement->medical_leave_balance . ' days left.')->withInput();
                }
            }
        }

        //  Check daily limit & determine status
        $tempApplication = new LeaveApplication([
            'user_id'    => $targetUser->id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'total_days' => $totalDays,
        ]);
        $tempApplication->setRelation('user', $targetUser);

        $initialStatus = 'pending';

        if (!$tempApplication->isExemptFromDailyLimit()) {
            $dates = $tempApplication->getLeaveDates();
            $maxCount = 0;

            foreach ($dates as $date) {
                $dailyCount    = DailyLeaveCount::where('leave_date', $date)->first();
                $approvedCount = $dailyCount ? $dailyCount->other_staff_count : 0;

                $pendingCount = LeaveApplication::where('status', 'pending')
                    ->where('user_id', '!=', $targetUser->id)
                    ->whereNotIn('leave_type', ['ML', 'PL'])
                    ->where(function($q) use ($date) {
                        $q->where('start_date', '<=', $date)->where('end_date', '>=', $date);
                    })
                    ->whereHas('user', function($q) {
                        $q->whereNotIn('position', ['Customer Support Engineer', 'Lead Customer Support Engineer'])
                        ->whereNotIn('role', ['part_time', 'staff_ge']);
                    })
                    ->count();

                $total = $approvedCount + $pendingCount;
                if ($total > $maxCount) $maxCount = $total;
            }

            if ($maxCount >= 2) $initialStatus = 'waiting_list';
        }

        //  Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $sanitized = time() . '_' . $targetUser->id . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $attachmentPath = $file->storeAs('leave_attachments', $sanitized, 'public');
        }

        //  Create the application
        LeaveApplication::create([
            'user_id'          => $targetUser->id,
            'leave_type'       => $request->leave_type,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'total_days'       => $totalDays,
            'is_half_day'      => $isHalfDay,
            'half_day_period'  => $isHalfDay ? $request->half_day_period : null,
            'reason'           => $request->reason,
            'attachment'       => $attachmentPath,
            'status'           => $initialStatus,
            'approved_by'      => Auth::id(),
            'approved_at'      => null,
            'approval_note'    => $request->leave_type === 'SL' ? $request->approval_note : null,
        ]);

        $staffName = $targetUser->name;

        if ($initialStatus === 'waiting_list') {
            return redirect()->route('admin.leave.apply-for-staff')
                ->with('warning', "Leave submitted for {$staffName}, but placed on WAITING LIST — daily limit reached for selected date(s).");
        }

        return redirect()->route('admin.leave.apply-for-staff')
            ->with('success', "Leave application submitted successfully for {$staffName}! Status: Pending.");
    }
    /**
     * Download attachment
     */
    public function downloadAttachment($id)
    {
        $application = LeaveApplication::findOrFail($id);

        if (!$application->attachment) {
            return back()->with('error', 'No attachment found.');
        }

        return Storage::disk('public')->download($application->attachment);
    }

    /**
     * Update staff leave entitlement (Admin only)
     */
    public function updateEntitlement(Request $request, $entitlementId)
    {
        $request->validate([
            'annual_leave_total' => 'required|integer|min:0|max:365',
            'medical_leave_total' => 'required|integer|min:0|max:365',
        ], [
            'annual_leave_total.required' => 'Annual Leave Total is required.',
            'annual_leave_total.integer' => 'Annual Leave Total must be a number.',
            'annual_leave_total.min' => 'Annual Leave Total cannot be negative.',
            'annual_leave_total.max' => 'Annual Leave Total cannot exceed 365 days.',
            'medical_leave_total.required' => 'Medical Leave Total is required.',
            'medical_leave_total.integer' => 'Medical Leave Total must be a number.',
            'medical_leave_total.min' => 'Medical Leave Total cannot be negative.',
            'medical_leave_total.max' => 'Medical Leave Total cannot exceed 365 days.',
        ]);

        DB::beginTransaction();

        try {
            $entitlement = LeaveEntitlement::findOrFail($entitlementId);

            //  Validation: Cannot set total LESS than already used
            if ($request->annual_leave_total < $entitlement->annual_leave_used) {
                DB::rollBack();
                return back()->with('error',
                    "Cannot set Annual Leave Total to {$request->annual_leave_total} days. " .
                    "Staff has already used {$entitlement->annual_leave_used} days."
                );
            }

            if ($request->medical_leave_total < $entitlement->medical_leave_used) {
                DB::rollBack();
                return back()->with('error',
                    "Cannot set Medical Leave Total to {$request->medical_leave_total} days. " .
                    "Staff has already used {$entitlement->medical_leave_used} days."
                );
            }

            //  Update entitlement
            $entitlement->update([
                'annual_leave_total' => $request->annual_leave_total,
                'medical_leave_total' => $request->medical_leave_total,
            ]);

            DB::commit();

            $staffName = $entitlement->user->name;
            return back()->with('success',
                "Leave entitlement updated successfully for {$staffName}! " .
                "New totals: {$request->annual_leave_total} AL, {$request->medical_leave_total} MC."
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating entitlement: ' . $e->getMessage());
        }
    }
}
