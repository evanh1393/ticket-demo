<?php

namespace App\Filament\Resources;

use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('priority')
                    ->required()
                    ->options([
                        'High' => 'High',
                        'Medium' => 'Medium',
                        'Low' => 'Low',
                    ]),
                Forms\Components\TextInput::make('department')
                    ->required()
                    ->maxLength(255),
//                Forms\Components\Select::make('location_id')
//                    ->relationship('location', 'title')
//                    ->required(),
                Forms\Components\TextInput::make('display_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'Point of Sale' => 'Point of Sale',
                        'Back-office Computer' => 'Back-office Computer',
                        'Tablet' => 'Tablet',
                        'MFC Printer/Scanner' => 'MFC Printer/Scanner',
                        'Receipt Printer' => 'Receipt Printer',
                        'Telephone' => 'Telephone',
                        'Internet' => 'Internet',
                        'Login Issues' => 'Login Issues',
                        'Other' => 'Other',
                    ]),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options(array_combine(
                        array_map(fn($status) => $status->value, TicketStatus::cases()),
                        array_map(fn($status) => $status->value, TicketStatus::cases())
                    )),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assigned_to')
                    ->numeric()
                    ->sortable(),
                ViewColumn::make('accept_ticket')
                    ->view('tables.actions.accept_ticket')
                    ->visible(fn($record): bool => Auth::user()->can('update', $record)),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_by')
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
