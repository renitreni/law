<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UserReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-reminder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will process the upcoming event to users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
