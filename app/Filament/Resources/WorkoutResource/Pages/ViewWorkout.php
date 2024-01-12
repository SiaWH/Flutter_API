<?php

namespace App\Filament\Resources\WorkoutResource\Pages;

use App\Filament\Resources\WorkoutResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkout extends ViewRecord
{
    protected static string $resource = WorkoutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
