<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AppPanelProvider::class,
    App\Providers\HorizonServiceProvider::class,
    config('app.env') !== 'production' ? Opcodes\LogViewer\LogViewerServiceProvider::class : null,
];
