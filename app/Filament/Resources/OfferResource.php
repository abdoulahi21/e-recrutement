<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->minDate(now()->addDays(3))
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'cdi' => 'CDI',
                        'cdd' => 'CDD',
                        'stage' => 'Stage',
                        'alternance' => 'Alternance',
                        'freelance' => 'Freelance',
                        'benevolat' => 'Benevolat',
                        'apprentissage' => 'Apprentissage',
                    ])
                    ->default('stage')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('ouvert')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Recruiter')
                    ->options(function () {
                        return \App\Models\User::where('role_id', 2)
                            ->get()
                            ->mapWithKeys(function ($user) {
                                return [
                                    $user->id => $user->last_name . ' ' . $user->first_name . ' Compagny: ' . $user->compagny_name
                                ];
                            });
                    })
                    ->required()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(25)
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.compagny_name')
                    ->label('Compagny')
                    ->sortable()
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
                // filters user
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Recruiter')
                    ->options(function () {
                        return \App\Models\User::where('role_id', 2)
                            ->get()
                            ->mapWithKeys(function ($user) {
                                return [
                                    $user->id => $user->last_name . ' ' . $user->first_name . ' Compagny: ' . $user->compagny_name
                                ];
                            });
                    })
                    ->searchable(),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'ouvert' => 'Ouvert',
                        'fermer' => 'Fermer',
                    ])->searchable(),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'stage' => 'Stage',
                        'emploi' => 'Emploi',
                        'alternance' => 'Alternance',
                        'freelance' => 'Freelance',
                    ])
                    ->searchable(),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
