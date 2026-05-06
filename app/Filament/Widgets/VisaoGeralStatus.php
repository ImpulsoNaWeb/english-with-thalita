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
            Stat::make('Planos de Estudo', Servico::count())
                ->description('Planos cadastrados')
                ->descriptionIcon('heroicon-m-academic-cap')
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
