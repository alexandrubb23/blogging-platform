<?php

namespace App\Services\ScheduleCommands;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;

abstract class ScheduleCommandsFrequency
{
    /**
     * Schedule instance.
     * 
     * @var Schedule
     */
    protected Schedule $schedule;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Schedule command.
     * 
     * @return Event
     */
    protected function scheduleCommand(string $commandSignature, ...$parameters): Event
    {
        return $this->schedule->command($commandSignature, $parameters);
    }

    /**
     * Frequency of command.
     * 
     * @return Event
     */
    abstract public function frequency(): Event;
}
