<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\AutoImportBlogPostsCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // We can create a service with a bunch of commands using the Polymorphism principle, for instance:
        // $commands = CommandsSchedule::($schedule)->commands();
        // foreach ($commands as $command) {
        //     $command->execute();
        // }
        // And execute method will return a different interval type to execute the command.

        $command = AutoImportBlogPostsCommand::IMPORT_POSTS_SIGNATURE;
        $schedule->command($command)->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
