<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoachResource\Pages;
use App\Filament\Resources\CoachResource\RelationManagers;
use App\Models\Coach;
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

class CoachResource extends Resource
{
    protected static ?string $model = Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coach Details')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(191),
                    Forms\Components\TextInput::make('age')
                        ->required()
                        ->minValue(15)
                        ->maxValue(100)
                        ->numeric(),
                    Forms\Components\Select::make('gender')
                        ->required()
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ]),
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->required()
                        ->columnSpanFull(),
                ])->columns(3),
                Forms\Components\Section::make('Coach experiences')
                ->schema([
                    Forms\Components\TextInput::make('experience_years')
                        ->required()
                        ->minValue(1)
                        ->maxValue(100)
                        ->numeric(),
                    Forms\Components\TextInput::make('rate')
                        ->required()
                        ->numeric()
                        ->minValue(0.1)
                        ->maxValue(5.0)
                        ->default(5.0),
                    Forms\Components\Textarea::make('description')
                        ->maxLength(900)
                        ->rows(6)
                        ->required()
                        ->columnSpanFull(),
                ])->columns(2),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
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
                SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
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
                ->successNotificationTitle('Coach deleted'),
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
            'index' => Pages\ListCoaches::route('/'),
            'create' => Pages\CreateCoach::route('/create'),
            'view' => Pages\ViewCoach::route('/{record}'),
            'edit' => Pages\EditCoach::route('/{record}/edit'),
        ];
    }
}
