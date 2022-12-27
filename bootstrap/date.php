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
function parseISO8601ToDateAndTime($date, $timeZone = 'UTC'): string
{
    return Carbon::parse($date)->setTimezone($timeZone)->format('Y-m-d H:i:s');
}
