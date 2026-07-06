<?php

namespace App\Helpers;

use Carbon\Carbon;

class IcHelper
{
    /**
     * Extract date of birth from Malaysian IC number
     *
     * @param string $ic - 12 digit IC number
     * @return string|null - Date in Y-m-d format or null if invalid
     */
    public static function extractDateOfBirth($ic)
    {
        // Remove any dashes or spaces
        $ic = preg_replace('/[^0-9]/', '', $ic);

        // Check if IC is 12 digits
        if (strlen($ic) !== 12) {
            return null;
        }

        // Extract YYMMDD from first 6 digits
        $year = substr($ic, 0, 2);
        $month = substr($ic, 2, 2);
        $day = substr($ic, 4, 2);

        // Determine century (if year > current year's last 2 digits, it's 1900s, else 2000s)
        $currentYear = date('y'); // Get last 2 digits of current year

        if ($year > $currentYear) {
            // Born in 1900s
            $fullYear = '19' . $year;
        } else {
            // Born in 2000s
            $fullYear = '20' . $year;
        }

        // Validate date
        if (!checkdate($month, $day, $fullYear)) {
            return null;
        }

        // Return in Y-m-d format
        return $fullYear . '-' . $month . '-' . $day;
    }

    /**
     * Calculate age from IC number
     *
     * @param string $ic - 12 digit IC number
     * @return int|null - Age in years or null if invalid
     */
    public static function calculateAge($ic)
    {
        $dob = self::extractDateOfBirth($ic);

        if (!$dob) {
            return null;
        }

        return Carbon::parse($dob)->age;
    }
    /**
     * Check if id_number is Malaysian IC format
     */
    public static function isMalaysianIc($idNumber)
    {
        $clean = preg_replace('/[^0-9]/', '', $idNumber);
        return strlen($clean) === 12;
    }
}
