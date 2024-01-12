<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkoutResource\Pages;
use App\Filament\Resources\WorkoutResource\RelationManagers;
use App\Models\Workout;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class WorkoutResource extends Resource
{
    protected static ?string $model = Workout::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                    
                Forms\Components\Select::make('type')
                ->required()
                ->options([
                    'chest' => 'Chest',
                    'triceps' => 'Triceps',
                    'biceps' => 'Biceps',
                    'shoulders' => 'Shoulders',
                    'legs' => 'Legs',
                    'abs' => 'Abs',
                    'back' => 'Back',
                ]),
                Forms\Components\Select::make('difficulty')
                    ->options([
                        0 => 'Beginner',
                        1 => 'Easy',
                        2 => 'Normal',
                        3 => 'Advanced',
                        4 => 'Hard',
                        5 => 'Master',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('gif')
                    ->required()
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->multiple()
                    ->options([
                        'chest' => 'Chest',
                        'triceps' => 'Triceps',
                        'biceps' => 'Biceps',
                        'shoulders' => 'Shoulders',
                        'legs' => 'Legs',
                        'abs' => 'Abs',
                        'back' => 'Back',
                    ]),
                SelectFilter::make('difficulty')
                    ->multiple()
                    ->options([
                        0 => 'Beginner',
                        1 => 'Easy',
                        2 => 'Normal',
                        3 => 'Advanced',
                        4 => 'Hard',
                        5 => 'Master',
                    ]),
                    Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): ?array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Created from' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Created until' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }
                 
                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->successNotificationTitle('Workout deleted'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkouts::route('/'),
            'create' => Pages\CreateWorkout::route('/create'),
            'view' => Pages\ViewWorkout::route('/{record}'),
            'edit' => Pages\EditWorkout::route('/{record}/edit'),
        ];
    }
}
