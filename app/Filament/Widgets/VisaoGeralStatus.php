<?php

namespace App\Filament\Widgets;

use App\Models\Servico;
use App\Models\Depoimento;
use App\Models\Visita;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VisaoGeralStatus extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Serviços', Servico::count())
                ->description('Serviços cadastrados')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('success'),
            Stat::make('Depoimentos', Depoimento::count())
                ->description('Feedbacks de alunos')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
                ->color('info'),
            Stat::make('Visitas Hoje', Visita::whereDate('visitado_em', today())->count())
                ->description('Total de acessos hoje')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning'),
        ];
    }
}
