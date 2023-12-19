<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetDailyKcal extends Command
{
    protected $signature = 'reset:daily-user-kcal';
    protected $description = 'Reset daily kcal for all records where the day has passed';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // Check if the last intake date is before the current day
            if ($user->last_intake_date < now()->startOfDay()) {
                // Reset daily kcal to 0
                $user->update(['kcal' => 0]);
            }
        }

        $this->info('Daily user kcal reset completed.');
    }
}
