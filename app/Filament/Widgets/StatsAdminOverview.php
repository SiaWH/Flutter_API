<?php

namespace App\Filament\Widgets;

use App\Models\Food;
use App\Models\User;
use App\Models\Workout;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count())
                ->description('All users from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Workouts', Workout::query()->count())
                ->description('All workouts from the database'),
            Stat::make('Foods', Food::query()->count())
                ->description('All foods from the database'),
        ];
    }
}
