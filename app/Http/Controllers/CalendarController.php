<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveApplication;
use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Show calendar page (main view)
     */
    public function index(Request $request)
    {
        // Get current month and year (or from request)
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        // Get calendar data
        $calendarData = $this->getCalendarData($year, $month);

        return view('calendar.index', compact('calendarData', 'year', 'month'));
    }

    /**
     * Get calendar data for a specific month
     */
    public function getCalendarData($year, $month)
    {
        // Create date range for the month
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Get approved leaves for this month
        $approvedLeaves = LeaveApplication::with('user')
            ->approved()
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
     * Store new calendar event (Admin only)
     */
    public function storeEvent(Request $request)
    {
        // Check if user is admin
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Only admin can add events.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'nullable|string|max:500',
            'color' => 'required|in:green,yellow,orange,red,blue,purple,pink',
        ]);

        CalendarEvent::create([
            'title' => $request->title,
            'event_date' => $request->event_date,
            'description' => $request->description,
            'color' => $request->color,
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Event added successfully!');
    }

    /**
     * Delete calendar event (Admin only)
     */
    public function deleteEvent($id)
    {
        // Check if user is admin
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            return back()->with('error', 'Only admin can delete events.');
        }

        $event = CalendarEvent::findOrFail($id);
        $event->delete();

        return back()->with('success', 'Event deleted successfully!');
    }

    /**
     * Get calendar data as JSON (for AJAX requests)
     */
    public function getCalendarDataJson(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $calendarData = $this->getCalendarData($year, $month);

        return response()->json([
            'success' => true,
            'data' => $calendarData,
            'year' => $year,
            'month' => $month,
        ]);
    }
}
