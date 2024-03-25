<?php

namespace App\Console\Commands;

use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UserAnnouncementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-announcement-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all Users of the system of upcoming events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::pluck('email')->toArray();
        $entries = Entry::where('entry_date', Carbon::now()->addDays(5)->format('Y-m-d'))->get()->toArray();
        dump(Carbon::now()->addDays(5)->format('Y-m-d'));
        dump($entries);
        dd($users);
    }
}
