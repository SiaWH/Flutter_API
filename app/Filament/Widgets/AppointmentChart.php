<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AppointmentChart extends ChartWidget
{
    protected static ?string $heading = 'Appointment Chart';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(Appointment::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Appointments',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
