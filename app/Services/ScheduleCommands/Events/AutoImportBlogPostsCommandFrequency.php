<?php

namespace App\Services\ScheduleCommands\Events;

use Illuminate\Console\Scheduling\Event;

use App\Console\Commands\AutoImportBlogPostsCommand;
use App\Services\ScheduleCommands\ScheduleCommandsFrequency;

class AutoImportBlogPostsCommandFrequency extends ScheduleCommandsFrequency
{
    /**
     * @inheritdoc
     */
    public function frequency(): Event
    {
        $commandSignature = AutoImportBlogPostsCommand::COMMAND_SIGNATURE;
        $command = $this->scheduleCommand($commandSignature);

        return $command->hourly();
    }
}
