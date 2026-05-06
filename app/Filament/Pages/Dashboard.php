<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string | \UnitEnum | null $navigationGroup = 'Site';
    protected static ?int $navigationSort = -1;
}
