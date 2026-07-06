<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LeaveApplication;
use App\Models\CalendarEvent;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Show staff dashboard
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        //  Get current year and month (with navigation support)
        $currentYear = $request->get('year', date('Y'));
        $currentMonth = $request->get('month', date('m'));

        //  Get calendar data (same as admin)
        $calendarData = $this->getCalendarData($currentYear, $currentMonth);

        return view('staff.dashboard', compact('calendarData', 'currentYear', 'currentMonth'));
    }

    /**
     *  Get calendar data for a specific month (SAME AS ADMIN)
     */
    private function getCalendarData($year, $month)
    {
        // Create date range for the month
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get approved leaves for this month
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

        // Get calendar events for this month
        $calendarEvents = CalendarEvent::with('creator')
            ->whereBetween('event_date', [$startDate, $endDate])
            ->get();

        // Organize data by date
        $calendar = [];

        // Process leaves
        foreach ($approvedLeaves as $leave) {
            $current = Carbon::parse($leave->start_date);
            $end = Carbon::parse($leave->end_date);

            while ($current->lte($end)) {
                // Only include dates in current month
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
                        'start_date' => $leave->start_date->format('Y-m-d'),
                        'end_date' => $leave->end_date->format('Y-m-d'),
                        'total_days' => $leave->total_days,
                    ];

                    $calendar[$dateKey]['count']++;
                }

                $current->addDay();
            }
        }

        // Process calendar events
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
     * Show Team Staff (same view as admin but for staff)
     */
    /**
     * Show Team Staff (same view as admin but for staff)
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
                'color' => '#92400e',   // deep amber/brown
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

        return view('staff.team_staff', compact('teams', 'totalStaff', 'totalTeams'));
    }
}
