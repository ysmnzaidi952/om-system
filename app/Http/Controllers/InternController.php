<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LeaveApplication;
use App\Models\LeaveEntitlement;
use App\Models\CalendarEvent;
use Carbon\Carbon;

class InternController extends Controller
{
    /**
     * Display intern dashboard
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        //  Get year and month from request or use current
        $currentYear = $request->get('year', now()->year);
        $currentMonth = $request->get('month', now()->month);

        //  Check if internship dates are set
        $datesNotSet = !$user->internship_start_date || !$user->internship_end_date;

        // Calculate internship stats
        $daysWorked = 0;
        $daysRemaining = 0;

        if ($user->internship_start_date && $user->internship_end_date) {
            $startDate = Carbon::parse($user->internship_start_date);
            $endDate = Carbon::parse($user->internship_end_date);
            $today = Carbon::today();

            // Days worked (from start to today, or 0 if not started yet)
            if ($today->gte($startDate)) {
                $daysWorked = $startDate->diffInDays($today) + 1;
            }

            // Days remaining (from today to end, or total days if not started yet)
            if ($today->lte($endDate)) {
                $daysRemaining = $today->diffInDays($endDate);
            }
        }

        // Get leave entitlement
        $entitlement = $user->getOrCreateEntitlement();

        // Get recent leave applications
        $recentApplications = LeaveApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // This month leaves count
        $thisMonthLeaves = LeaveApplication::where('user_id', $user->id)
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->count();

        //  Get calendar data for the selected month (SAME AS ADMIN)
        $calendarData = $this->getCalendarData($currentYear, $currentMonth);

        return view('intern.dashboard', compact(
            'user',
            'datesNotSet',
            'daysWorked',
            'daysRemaining',
            'entitlement',
            'recentApplications',
            'thisMonthLeaves',
            'currentYear',      //  ADDED
            'currentMonth',     //  ADDED (as integer)
            'calendarData'      //  UPDATED structure
        ));
    }

/**
     * Display team staff page (SAME STRUCTURE AS STAFF)
     */
    public function teamStaff()
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

        return view('intern.team-staff', compact('teams', 'totalStaff', 'totalTeams'));
    }

    /**
     *  Get calendar data for mini calendar (SAME STRUCTURE AS ADMIN)
     */
    private function getCalendarData($year, $month)
    {
        // Get all approved leaves for the month
        $leaves = LeaveApplication::where('status', 'approved')
            ->whereMonth('start_date', '<=', $month)
            ->whereMonth('end_date', '>=', $month)
            ->whereYear('start_date', $year)
            ->with('user')
            ->get();

        // Get all calendar events for the month
        $events = CalendarEvent::whereMonth('event_date', $month)
            ->whereYear('event_date', $year)
            ->with('creator')
            ->get();

        $calendarData = [];

        // Process leaves
        foreach ($leaves as $leave) {
            $startDate = Carbon::parse($leave->start_date);
            $endDate = Carbon::parse($leave->end_date);

            // Generate all dates in the leave period
            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                // Only include dates in the current month
                if ($current->month == $month && $current->year == $year) {
                    $dateKey = $current->format('Y-m-d');

                    if (!isset($calendarData[$dateKey])) {
                        $calendarData[$dateKey] = [
                            'count' => 0,
                            'leaves' => [],
                            'events' => []
                        ];
                    }

                    $calendarData[$dateKey]['count']++;
                    $calendarData[$dateKey]['leaves'][] = [
                        'staff_name' => $leave->user->name,
                        'leave_type' => $leave->leave_type,
                        'leave_type_name' => $this->getLeaveTypeName($leave->leave_type),
                        'total_days' => $leave->total_days
                    ];
                }

                $current->addDay();
            }
        }

        // Process events
        foreach ($events as $event) {
            $dateKey = Carbon::parse($event->event_date)->format('Y-m-d');

            if (!isset($calendarData[$dateKey])) {
                $calendarData[$dateKey] = [
                    'count' => 0,
                    'leaves' => [],
                    'events' => []
                ];
            }

            $calendarData[$dateKey]['events'][] = [
                'title' => $event->title,
                'description' => $event->description,
                'created_by' => $event->creator->name ?? 'Admin'
            ];
        }

        return $calendarData;
    }

    /**
     *  Get leave type display name
     */
    private function getLeaveTypeName($type)
    {
        $types = [
            'AL' => 'Annual Leave',
            'EL' => 'Emergency Leave',
            'MC' => 'Medical Certificate',
            'CL' => 'Compassionate Leave',
            'WFH' => 'Work From Home',
            'ML' => 'Maternity Leave',
            'PL' => 'Paternity Leave',
            'RL' => 'Replacement Leave',
            'MRL' => 'Medical Report Leave',
            'HALF_DAY_AL' => 'Half Day Annual Leave',
            'HALF_DAY_EL' => 'Half Day Emergency Leave'
        ];

        return $types[$type] ?? $type;
    }
}
