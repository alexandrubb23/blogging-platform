<?php

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Facades\Log;

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
function parseISO8601ToDateAndTime(string $date, string $format = 'Y-m-d H:i:s', string $timeZone = 'UTC'): string
{
    try {
        $carbon = Carbon::parse($date, $timeZone);
        return $carbon->format($format);
    } catch (InvalidFormatException $ex) {
        $errorMessage = sprintf('parseISO8601ToDateAndTime: %s', $ex->getMessage());
        Log::error($errorMessage);
    }

    return getCurrentDateAndTime();
}
