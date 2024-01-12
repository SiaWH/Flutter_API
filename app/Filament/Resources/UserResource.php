<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('status')
                    ->inline()
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(1),
                Forms\Components\Toggle::make('is_admin')
                    ->inline()
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(0),
                Forms\Components\Section::make('User Registerations')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(191),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(191),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->maxLength(191)
                        ->columnSpanFull(),
                ])->columns(2),
                Forms\Components\Section::make('User image')
                ->description('Nullable')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image(),
                ])->columnSpanFull(),

                Forms\Components\Section::make('User Details')
                ->schema([
                    Forms\Components\TextInput::make('age')
                        ->numeric()
                        ->minValue(15)
                        ->maxValue(100)
                        ->required(),
                    Forms\Components\Select::make('gender')
                        ->options([
                            'Male' => 'Male',
                            'Female' => 'Female',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('height')
                        ->numeric()
                        ->minValue(90)
                        ->maxValue(250)
                        ->required(),
                    Forms\Components\TextInput::make('weight')
                        ->numeric()
                        ->minValue(25)
                        ->required(),
                    Forms\Components\Select::make('experience')
                        ->options([
                            0 => 'Beginner',
                            1 => 'Intermediate',
                            2 => 'Advanced',
                        ])
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('basal_metabolism')
                        ->required()
                        ->numeric()
                        ->readOnly(),
                    Forms\Components\TextInput::make('BMI')
                        ->numeric()
                        ->readOnly(),
                    
                ])
                ->columns(2)
                ->live()
                ->afterStateUpdated(function (Get $get, Set $set) {
                    self::statusCalculation($get, $set);
                }),

                

            ]);
    }

    public static function statusCalculation(Get $get, Set $set) : void
    {
        $age = intval($get('age'));
        $gender = ($get('gender'));
        $height = doubleval($get('height'));
        $weight = doubleval($get('weight'));

        if ($age && $gender && $height && $weight) {
            $bmi = $weight / (($height / 100) * ($height / 100));
            $basalMetabolism = ($gender == 'Male')
                ? 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age)
                : 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);

                $roundedBasalMetabolism = round($basalMetabolism);
    
            $set('basal_metabolism', number_format($roundedBasalMetabolism, 0, '.', ''));
            $set('BMI', number_format($bmi, 2, '.', ''));
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('status'),
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
                SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Forbidden',
                    ]),
                SelectFilter::make('is_admin')
                    ->options([
                        1 => 'Admin',
                        0 => 'Non-admin',
                    ]),
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
                ->successNotificationTitle('User deleted'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
