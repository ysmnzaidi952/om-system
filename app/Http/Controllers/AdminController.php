<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LeaveApplication;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard(Request $request)
    {
        // Get year/month from request or use current
        $currentYear = $request->get('year', date('Y'));
        $currentMonth = $request->get('month', date('m'));

        //  UPDATED Stats - Exclude superadmin from counts
        $totalStaff = User::whereIn('role', ['staff', 'admin', 'intern', 'superadmin', 'part_time', 'staff_ge'])->count(); // Include superadmin
        $pendingApproval = User::whereIn('role', ['staff', 'intern'])->where('status', 'pending')->count();
        $activeStaff = User::where('status', 'active')->whereIn('role', ['staff', 'admin', 'intern', 'superadmin', 'part_time', 'staff_ge'])->count(); // Include superadmin
        // Get calendar data
        $calendarData = $this->getCalendarData($currentYear, $currentMonth);

        return view('admin.dashboard', compact(
            'totalStaff',
            'pendingApproval',
            'activeStaff',
            'calendarData',
            'currentYear',
            'currentMonth'
        ));
    }

    /**
     * Get calendar data for dashboard mini calendar
     */
    private function getCalendarData($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get approved leaves
        $approvedLeaves = LeaveApplication::with('user')
            ->whereIn('status', ['approved', 'special_case_approved'])
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->get();

        // Get calendar events
        $calendarEvents = CalendarEvent::with('creator')
            ->whereBetween('event_date', [$startDate, $endDate])
            ->get();

        $calendar = [];

        // Process leaves
        foreach ($approvedLeaves as $leave) {
            $current = Carbon::parse($leave->start_date);
            $end = Carbon::parse($leave->end_date);

            while ($current->lte($end)) {
                if ($current->month == $month && $current->year == $year) {
                    $dateKey = $current->format('Y-m-d');

                    if (!isset($calendar[$dateKey])) {
                        $calendar[$dateKey] = [
                            'leaves' => [],
                            'events' => [],
                            'count' => 0
                        ];
                    }

                    $calendar[$dateKey]['leaves'][] = [
                        'id' => $leave->id,
                        'staff_name' => $leave->user->name,
                        'leave_type' => $leave->leave_type,
                        'leave_type_name' => $leave->leave_type_name,
                        'total_days' => $leave->total_days,
                    ];

                    $calendar[$dateKey]['count']++;
                }

                $current->addDay();
            }
        }

        // Process events
        foreach ($calendarEvents as $event) {
            $dateKey = $event->event_date->format('Y-m-d');

            if (!isset($calendar[$dateKey])) {
                $calendar[$dateKey] = [
                    'leaves' => [],
                    'events' => [],
                    'count' => 0
                ];
            }

            $calendar[$dateKey]['events'][] = [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'color' => $event->color,
                'created_by' => $event->creator->name,
            ];
        }

        return $calendar;
    }

    /**
     * Show list of pending staff for approval
     */
    public function showPendingStaff()
    {
        $pendingStaff = User::whereIn('role', ['staff', 'intern', 'part_time', 'staff_ge'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin.pending_staff', compact('pendingStaff'));
    }

    /**
     * Approve staff registration
     */
    public function approveStaff($id)
    {
        $staff = User::findOrFail($id);

        $allowedRoles = ['staff', 'intern', 'part_time', 'staff_ge'];

        if (in_array($staff->role, $allowedRoles) && $staff->status === 'pending') {
            $staff->status = 'active';
            $staff->date_confirmed = now();
            $staff->save();

            $year = now()->year;

            $existingEntitlement = \App\Models\LeaveEntitlement::where('user_id', $staff->id)
                ->where('year', $year)
                ->first();

            if (!$existingEntitlement) {
                if ($staff->role === 'intern') {
                    \App\Models\LeaveEntitlement::create([
                        'user_id'             => $staff->id,
                        'year'                => $year,
                        'annual_leave_total'  => 5,
                        'annual_leave_used'   => 0,
                        'medical_leave_total' => 5,
                        'medical_leave_used'  => 0,
                    ]);
                    $leaveInfo = '(5 AL + 5 MC for entire internship period)';

                } elseif ($staff->role === 'part_time') {
                    \App\Models\LeaveEntitlement::create([
                        'user_id'             => $staff->id,
                        'year'                => $year,
                        'annual_leave_total'  => 0, // tiada count
                        'annual_leave_used'   => 0,
                        'medical_leave_total' => 0,
                        'medical_leave_used'  => 0,
                    ]);
                    $leaveInfo = '(AL only, no yearly limit)';

                } elseif ($staff->role === 'staff_ge') {
                    \App\Models\LeaveEntitlement::create([
                        'user_id'             => $staff->id,
                        'year'                => $year,
                        'annual_leave_total'  => 0, // tiada count
                        'annual_leave_used'   => 0,
                        'medical_leave_total' => 0,
                        'medical_leave_used'  => 0,
                    ]);
                    $leaveInfo = '(AL + MC, no yearly limit)';

                } else {
                    \App\Models\LeaveEntitlement::create([
                        'user_id'             => $staff->id,
                        'year'                => $year,
                        'annual_leave_total'  => 14,
                        'annual_leave_used'   => 0,
                        'medical_leave_total' => 14,
                        'medical_leave_used'  => 0,
                    ]);
                    $leaveInfo = '(14 AL + 14 MC for ' . $year . ')';
                }
            } else {
                $leaveInfo = '(entitlement already exists)';
            }

            $roleText = ucfirst(str_replace('_', ' ', $staff->role));

            return redirect()->route('admin.pending-staff')
                ->with('success', $roleText . ' approved! ' . $staff->name . ' can now login. Leave entitlements created ' . $leaveInfo);
        }

        return redirect()->route('admin.pending-staff')->with('error', 'Unable to approve this user.');
    }

    /**
     * Reject/Delete staff registration
     */
    public function rejectStaff($id)
    {
        $staff = User::findOrFail($id);

        if (in_array($staff->role, ['staff', 'intern', 'part_time', 'staff_ge']) && $staff->status === 'pending') {
            $staffName = $staff->name;
            $staff->delete();

            return redirect()->route('admin.pending-staff')->with('success', 'Registration rejected. ' . $staffName . ' has been removed from the system.');
        }

        return redirect()->route('admin.pending-staff')->with('error', 'Unable to reject this user.');
    }

    /**
     * Show all staff (active and inactive) including admin and intern
     */
    public function showAllStaff()
    {
        //  UPDATED: Include superadmin in display but with visual indicator
        $allStaff = User::whereIn('role', ['staff', 'admin', 'intern', 'superadmin', 'part_time', 'staff_ge']) // Include superadmin
                    ->orderBy('role', 'asc')
                    ->orderBy('status', 'asc')
                    ->orderBy('name', 'asc')
                    ->get();


        //  UPDATED: Total count including superadmin
$totalCount = User::whereIn('role', ['staff', 'admin', 'intern', 'superadmin', 'part_time', 'staff_ge'])->count(); // Include superadmin in count

        return view('admin.all_staff', compact('allStaff', 'totalCount'));
    }

    /**
     * View single staff details
     */
    public function viewStaff($id)
    {
        $staff = User::findOrFail($id);
        return view('admin.view_staff', compact('staff'));
    }

    /**
     * Deactivate staff account ( FIXED - includes intern)
     */
    public function deactivateStaff($id)
    {
        $staff = User::findOrFail($id);

        if (in_array($staff->role, ['staff', 'intern', 'part_time', 'staff_ge']) && $staff->status === 'active') {
            $staff->status = 'inactive';
            $staff->save();

            return redirect()->back()->with('success', $staff->name . ' account has been deactivated.');
        }

        return redirect()->back()->with('error', 'Unable to deactivate this user.');
    }

    /**
     * Reactivate staff account ( FIXED - includes intern)
     */
    public function reactivateStaff($id)
    {
        $staff = User::findOrFail($id);

        if (in_array($staff->role, ['staff', 'intern', 'part_time', 'staff_ge']) && $staff->status === 'inactive') {
            $staff->status = 'active';
            $staff->save();

            return redirect()->back()->with('success', $staff->name . ' account has been reactivated.');
        }

        return redirect()->back()->with('error', 'Unable to reactivate this user.');
    }

    /**
     * Show edit staff form ( FIXED - includes intern)
     */
    public function editStaff($id)
    {
        $staff = User::findOrFail($id);

        //  UPDATED: Allow editing of superadmin accounts
        if (!in_array($staff->role, ['staff', 'admin', 'intern', 'superadmin', 'part_time', 'staff_ge'])) {
            return redirect()->route('admin.all-staff')->with('error', 'Cannot edit this user.');
        }

        return view('admin.edit_staff', compact('staff'));
    }

    /**
     * Update staff information ( FIXED - includes intern)
     */
    public function updateStaff(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        //  UPDATED: Allow editing of superadmin accounts
        if (!in_array($staff->role, ['staff', 'admin', 'intern', 'superadmin', 'part_time', 'staff_ge'])) {
            return redirect()->route('admin.all-staff')->with('error', 'Cannot edit this user.');
        }

        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'phone_number' => 'nullable|string|max:20',
            'secondary_phone_number' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'staff_status' => 'nullable|string|max:50',
            'date_joined' => 'nullable|date',
            'date_confirmed' => 'nullable|date',
            'shirt_size' => 'nullable|string|max:10',
            'academic_qualification' => 'nullable|string',
            'years_of_experience' => 'nullable|string|max:50',
            'epf_number' => 'nullable|string|max:30',
            'bank_name' => 'nullable|string|max:50',
            'bank_account_number' => 'nullable|string|max:30',
            'ic_address' => 'nullable|string',
            'current_address' => 'nullable|string',
            'internship_start_date' => 'nullable|date',
            'internship_end_date' => 'nullable|date',
        ]);

        //  ROLE CHANGE LOGIC: Intern → Staff/Admin/Superadmin
        $oldRole = $staff->role;
        $newRole = $request->role ?? $staff->role;

        $updateData = [
            'name' => strtoupper($request->name),
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'secondary_phone_number' => $request->secondary_phone_number,
            'position' => $request->position,
            'staff_status' => $request->staff_status,
            'date_joined' => $request->date_joined,
            'date_confirmed' => $request->date_confirmed,
            'shirt_size' => $request->shirt_size,
            'academic_qualification' => $request->academic_qualification,
            'years_of_experience' => $request->years_of_experience,
            'epf_number' => $request->epf_number,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'ic_address' => $request->ic_address,
            'current_address' => $request->current_address,

        ];



        //  Intern kekal intern: update internship dates
        if ($oldRole === 'intern' && $newRole === 'intern') {
            $updateData['internship_start_date'] = $request->internship_start_date;
            $updateData['internship_end_date'] = $request->internship_end_date;
        }

        //  Intern tukar ke staff/admin/superadmin
        if ($oldRole === 'intern' && in_array($newRole, ['staff', 'admin', 'superadmin'])) {
            // 1. Clear internship dates
            $updateData['internship_start_date'] = null;
            $updateData['internship_end_date'] = null;

            // 2. Delete ALL intern leave entitlements
            \App\Models\LeaveEntitlement::where('user_id', $staff->id)->delete();

            // 3. Create new staff entitlement for current year (14AL + 14MC)
            \App\Models\LeaveEntitlement::create([
                'user_id'             => $staff->id,
                'year'                => date('Y'),
                'annual_leave_total'  => 14,
                'annual_leave_used'   => 0,
                'medical_leave_total' => 14,
                'medical_leave_used'  => 0,
            ]);
        }

        //  Tukar KE part_time atau staff_ge (dari mana-mana role)
        if (in_array($newRole, ['part_time', 'staff_ge']) && !in_array($oldRole, ['part_time', 'staff_ge'])) {
            \App\Models\LeaveEntitlement::where('user_id', $staff->id)->update([
                'annual_leave_total'  => 0,
                'annual_leave_used'   => 0,
                'medical_leave_total' => 0,
                'medical_leave_used'  => 0,
            ]);
        }

        //  Tukar DARI part_time/staff_ge ke staff/admin
        if (in_array($oldRole, ['part_time', 'staff_ge']) && in_array($newRole, ['staff', 'admin', 'superadmin'])) {
            \App\Models\LeaveEntitlement::where('user_id', $staff->id)->delete();
            \App\Models\LeaveEntitlement::create([
                'user_id'             => $staff->id,
                'year'                => date('Y'),
                'annual_leave_total'  => 14,
                'annual_leave_used'   => 0,
                'medical_leave_total' => 14,
                'medical_leave_used'  => 0,
            ]);
        }

        //  Update role
        if ($request->filled('role')) {
            $updateData['role'] = $newRole;
        }

        $staff->update($updateData);

        return redirect()->route('admin.view-staff', $id)->with('success', 'Staff information updated successfully!');
    }

    /**
     * Show Team Staff (Organization by Position) ( ADDED INTERN TEAM)
     */
    public function showTeamStaff()
    {
        $teamStructure = [
            'Management' => [
                'color' => '#0a5654',   // teal-base (dark teal)
                'positions' => ['Project/Operation Manager', 'Assistant Operation Manager']
            ],
            'Customer Support Team' => [
                'color' => '#0e7490',   // deep cyan
                'positions' => ['Lead Customer Support Engineer', 'Customer Support Engineer']
            ],
            'Application Support Team' => [
                'color' => '#1d4ed8',   // deep blue
                'positions' => ['Lead Application Support Engineer', 'Application Support Engineer']
            ],
            'Network & Security Team' => [
                'color' => '#065f46',   // deep emerald
                'positions' => ['Lead Network & Security Support Engineer', 'Network & Security Support Engineer']
            ],
            'Technical Support Team' => [
                'color' => '#92400e',   // deep amber
                'positions' => ['Lead Technical Support Engineer', 'Technical Support Engineer']
            ],
            'System Support Team' => [
                'color' => '#1e3a5f',   // deep navy
                'positions' => ['Lead System Support Engineer', 'System Support Engineer']
            ],
            'Database Team' => [
                'color' => '#5b21b6',   // deep purple
                'positions' => ['Database Administrator']
            ],
            'Interns' => [
                'color' => '#9f1239',   // deep rose
                'positions' => ['Intern']
            ],
            'Part Time' => [
                'color' => '#164e63',   // deep sky
                'positions' => ['Part Timer']
            ],
            'GE Support Team' => [
                'color' => '#3f6212',   // deep olive green
                'positions' => ['GE Support']
            ],
        ];

        $teams = [];
        foreach ($teamStructure as $teamName => $teamInfo) {
            $teams[$teamName] = [
                'color' => $teamInfo['color'],
                'staff' => User::whereIn('position', $teamInfo['positions'])
                            ->where('status', 'active')
                            ->orderByRaw("FIELD(position, '" . implode("','", $teamInfo['positions']) . "')")
                            ->orderBy('name', 'asc')
                            ->get()
            ];
        }

        $totalStaff = User::where('status', 'active')->count();
        $totalTeams = count(array_filter($teams, function($team) {
            return $team['staff']->count() > 0;
        }));

        return view('admin.team_staff', compact('teams', 'totalStaff', 'totalTeams'));
    }
}
