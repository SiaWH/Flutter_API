<?php

namespace App\Console\Commands;

use App\Models\NutrientIntake;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ResetDailyKcal extends Command
{
    protected $signature = 'reset:daily-user-kcal';
    protected $description = 'Reset daily kcal for all records where the day has passed';

    public function handle()
    {
        $yesterday = Carbon::now()->subDay();

        NutrientIntake::where('intake_time', '<=', $yesterday)->delete();

        $this->info('Expired nutrient intakes deleted successfully.');
    }
}
