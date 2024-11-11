<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Location;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->required(fn($record) => $record === null)
                            ->dehydrateStateUsing(fn($state) => $state ? bcrypt($state) : null)
                            ->dehydrated(fn($state) => filled($state)),
                    ])->columns(3),
                Forms\Components\Fieldset::make('Security')
                    ->schema([
                        Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->options(Role::all()->pluck('name', 'id')->toArray())
                            ->required(),
                    ])->columns(1)
                    ->visible(fn() => auth()->user()->hasRole('Admin')),
                Forms\Components\Fieldset::make('Store Assignment')
                    ->schema([
                        Select::make('locations')
                            ->label('Stores')
                            ->multiple()
                            ->relationship('locations', 'title')
                            ->options(Location::all()->pluck('title', 'id')->toArray())
                            ->required(),
                    ])->columns(1)
                    ->visible(fn() => auth()->user()->hasRole('Admin')),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location_name')
                    ->label('Stores'),
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
                SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->options(Role::all()->pluck('name', 'id')->toArray()),
                SelectFilter::make('locations')
                    ->options(fn() => Location::all()->pluck('brand', 'brand'))
                    ->modifyQueryUsing(function ($query, $state) {
                        if (!$state['value']) {
                            return $query;
                        }
                        return $query->whereHas('locations', fn($query) => $query->where('brand', $state['value']));
                    })
                    ->label('User Brands'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('roles.name');
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
