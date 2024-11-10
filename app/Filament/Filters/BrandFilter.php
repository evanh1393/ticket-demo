<?php

namespace App\Filament\Filters;

use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class BrandFilter extends Filter
{
    public static function make(string $name): static
    {
        return (new static())
            ->name($name)
            ->label('Brand')
            ->form([
                Forms\Components\Select::make('value')
                    ->options([
                        'BrandA' => 'BrandA',
                        'BrandB' => 'BrandB',
                        'BrandC' => 'BrandC',
                        'BrandD' => 'BrandD',
                        'BrandE' => 'BrandE',
                    ])
                    ->placeholder('Select a brand'),
            ]);
    }

    protected function setUp(): void
    {
        $this->query(function (Builder $query, array $data) {
            if (!empty($data['value'])) {
                $query->whereHas('locations', function ($query) use ($data) {
                    $query->where('brand', $data['value']);
                });
            }
        });
    }
}
