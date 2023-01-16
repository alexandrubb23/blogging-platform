<?php

use Illuminate\Support\Facades\Log;

it('should return the current date and time when getCurrentDateAndTime is called', function () {
    $date = getCurrentDateAndTime();

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $date);
});

it('should log the error and return the current date and time if parseISO8601ToDateAndTime is receiving an invalid date', function () {
    Log::spy();

    $date = parseISO8601ToDateAndTime('+');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $date);

    $errorMessage = 'parseISO8601ToDateAndTime: Could not parse \'+\': Failed to parse time string (+) at position 0 (+): Unexpected character';
    Log::shouldHaveReceived('error')->once()->with($errorMessage);
});


it('should return date and time when parseISO8601ToDateAndTime is called', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $date);
});


it('should return the year when parseISO8601ToDateAndTime is called with Y as format argument', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z', 'Y');

    $this->assertMatchesRegularExpression('/(\d{4})/', $date);
});

it('should return the year and month when parseISO8601ToDateAndTime is called with Y-m as format argument', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z', 'Y-m');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})/', $date);
});

it('should return year, month and day when parseISO8601ToDateAndTime is called with Y-m-d as format argument', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z', 'Y-m-d');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2})/', $date);
});

it('should return year, month and hour when parseISO8601ToDateAndTime is called with Y-m-d H as format argument', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z', 'Y-m-d H');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2}) (\d{2})/', $date);
});

it('should return year, month, day, hour and minutes when parseISO8601ToDateAndTime is called with Y-m-d H-m as format argument', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z', 'Y-m-d H-m');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2}) (\d{2})-(\d{2})/', $date);
});

it('should return year, month, day, hour, minutes and seconds when parseISO8601ToDateAndTime is called with Y-m-d H-m-s as format argument', function () {
    $date = parseISO8601ToDateAndTime('2022-08-31T10:08:30Z', 'Y-m-d H-m-s');

    $this->assertMatchesRegularExpression('/(\d{4})-(\d{2})-(\d{2}) (\d{2})-(\d{2})-(\d{2})/', $date);
});
