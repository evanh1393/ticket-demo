<?php

namespace App\Filament\Resources;

use App\Enums\TicketCategory;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
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
                Forms\Components\TextInput::make('display_id')
                    ->disabled()
                    ->maxLength(255)
                    ->visibleOn('edit'),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('priority')
                    ->required()
                    ->options(array_combine(
                        array_map(fn($priority) => $priority->value, TicketPriority::cases()),
                        array_map(fn($priority) => $priority->value, TicketPriority::cases())
                    )),
                Forms\Components\TextInput::make('department')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'title')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->required()
                    ->options(array_combine(
                        array_map(fn($category) => $category->value, TicketCategory::cases()),
                        array_map(fn($category) => $category->value, TicketCategory::cases())
                    )),
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
                Tables\Columns\TextColumn::make('display_id')
                    ->searchable()
                    ->extraAttributes(['style' => 'font-family: monospace;']),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->sortable()
                    ->badge()
                    ->color(fn($record) => match ($record->priority->value ?? '') {
                        TicketPriority::HIGH->value => Color::Rose,
                        TicketPriority::MEDIUM->value => Color::Yellow,
                        TicketPriority::LOW->value => Color::Emerald,
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('department')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
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
                Tables\Columns\TextColumn::make('total_tickets')
                    ->label('Total Tickets')
                    ->getStateUsing(fn() => Ticket::count()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        TicketPriority::HIGH->value => 'High',
                        TicketPriority::MEDIUM->value => 'Medium',
                        TicketPriority::LOW->value => 'Low',
                    ]),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
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
