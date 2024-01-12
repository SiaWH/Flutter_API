<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('coach_id')
                    ->relationship(
                        name: 'coach',
                        titleAttribute: 'name'
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                    Forms\Components\Select::make('user_id')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name'
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DateTimePicker::make('appointment_date_time')
                    ->required()
                    ->columnSpanFull()
                    ->minDate(Carbon::tomorrow()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('coach.name')
                    ->label('Coach')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_date_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
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
                Filter::make('appointment_date_time')
                    ->form([
                        DatePicker::make('appointment_from'),
                        DatePicker::make('appointment_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['appointment_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('appointment_date_time', '>=', $date),
                            )
                            ->when(
                                $data['appointment_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('appointment_date_time', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): ?array {
                        $indicators = [];
                        if ($data['appointment_from'] ?? null) {
                            $indicators['appointment_from'] = 'Appointment from' . Carbon::parse($data['appointment_from'])->toFormattedDateString();
                        }
                        if ($data['appointment_until'] ?? null) {
                            $indicators['appointment_until'] = 'Appointment until' . Carbon::parse($data['appointment_until'])->toFormattedDateString();
                        }
                 
                        return $indicators;
                    }),
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
                ->successNotificationTitle('Appointment deleted'),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
