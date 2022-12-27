<?php

use Carbon\Carbon;

/**
 * Get current date and time.
 * 
 * @return string
 */
function getCurrentDateAndTime(): string
{
    return Carbon::now()->toDateTimeString();
}

/**
 * Parse date to date and time.
 * 
 * @param string $date
 * @param string $timeZone
 * @return string
 */
function parseISO8601ToDateAndTime($date, $format = 'Y-m-d H:i:s', $timeZone = 'UTC'): string
{
    return Carbon::parse($date)->setTimezone($timeZone)->format($format);
}
