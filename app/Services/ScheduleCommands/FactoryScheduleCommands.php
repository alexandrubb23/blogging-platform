<?php

namespace App\Services\ScheduleCommands;

use InvalidArgumentException;
use Illuminate\Console\Scheduling\Schedule;

class FactoryScheduleCommands
{
    /**
     * Schedule instance.
     * 
     * @var Schedule
     */
    protected Schedule $schedule;

    /**
     * Create a new schedule command instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Create command instance.
     * 
     * @param string $commandName
     * @
     * @return ScheduleCommandsFrequency
     */
    private function createCommand(string $commandName): ScheduleCommandsFrequency
    {
        if (!class_exists($commandName)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The command class %s does not exist.",
                    $commandName
                )
            );
        }

        $command = new $commandName($this->schedule);
        if (!($command instanceof ScheduleCommandsFrequency)) {
            throw new InvalidArgumentException(
                sprintf(
                    "The command class %s must be an instance of %s.",
                    $commandName,
                    ScheduleCommandsFrequency::class
                )
            );
        }

        return $command;
    }

    /**
     * Execute commands.
     * 
     * @return void
     */
    public function executeCommands()
    {
        $commands = config('app.schedule_commands', []);

        foreach ($commands as $command) {
            $command = $this->createCommand($command);
            $command->frequency();
        }
    }
}
