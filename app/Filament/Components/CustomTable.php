<?php

namespace App\Filament\Components;

use Filament\Tables\Table as BaseTable;
use Illuminate\View\View;

class CustomTable extends BaseTable
{
    public function render(): View
    {
        return view('filament.components.custom-table', [
            'table' => $this,
        ]);
    }
}
