<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\IcHelper;
use Carbon\Carbon;
class BirthdayController extends Controller
{
    /**
     * Display all staff birthdays for current year
     */
    public function index(Request $request)
    {
        //  FIXED: Use Malaysia timezone
        Carbon::setLocale('en');
        $now = Carbon::now('Asia/Kuala_Lumpur');
        $currentYear = (int) $now->year;
        // Get filter inputs
        $selectedMonth = $request->get('month', 'all');
        $searchName = $request->get('search', '');
        // Get all active staff (admin, staff, intern)
        $staffQuery = User::whereIn('role', ['superadmin', 'admin', 'staff', 'intern'])
                          ->where('status', 'active');
        // Apply name search filter
        if ($searchName) {
            $staffQuery->where('name', 'LIKE', '%' . $searchName . '%');
        }
        $allStaff = $staffQuery->get();
        // Extract birthdays and organize by month
        $birthdaysByMonth = [];
        foreach ($allStaff as $staff) {
            // ── UPDATED: ic → id_number, and skip passport holders ──
            // (passport numbers don't encode a DOB the way Malaysian IC does)
            if (!$staff->id_number || $staff->id_type !== 'ic') continue;
            // Extract birthday from IC
            $birthday = IcHelper::extractDateOfBirth($staff->id_number);
            if (!$birthday) continue;
            //  FIXED: Get this year's birthday in Malaysia timezone
            $birthdayThisYear = Carbon::parse($birthday, 'Asia/Kuala_Lumpur')->setYear($currentYear);
            $month = $birthdayThisYear->month;
            $day = $birthdayThisYear->day;
            // Apply month filter if selected
            if ($selectedMonth !== 'all' && $month != $selectedMonth) {
                continue;
            }
            if (!isset($birthdaysByMonth[$month])) {
                $birthdaysByMonth[$month] = [];
            }
            //  FIXED: Compare dates in Malaysia timezone
            $isToday = $now->isSameDay($birthdayThisYear);
            $birthdaysByMonth[$month][] = [
                'staff' => $staff,
                'birthday_date' => $birthdayThisYear,
                'day' => $day,
                'month' => $month,
                'formatted_date' => $birthdayThisYear->format('d M'),
                'is_today' => $isToday, //  Now correctly checks Malaysia time
            ];
        }
        // Sort each month by day
        foreach ($birthdaysByMonth as $month => &$birthdays) {
            usort($birthdays, function($a, $b) {
                return $a['day'] - $b['day'];
            });
        }
        // Sort months (January to December)
        ksort($birthdaysByMonth);
        return view('birthdays.index', compact(
            'birthdaysByMonth',
            'currentYear',
            'selectedMonth',
            'searchName'
        ));
    }
}
