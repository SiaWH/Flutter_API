<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class FeedbackTable extends BaseWidget
{
    protected static ?string $heading = 'Feedbacks';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Feedback::query()
            )
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('comment'),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric(),
            ]);
    }
}
