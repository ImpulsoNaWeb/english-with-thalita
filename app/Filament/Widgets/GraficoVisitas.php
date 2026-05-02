<?php

namespace App\Filament\Widgets;

use App\Models\Visita;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GraficoVisitas extends ChartWidget
{
    protected ?string $heading = 'Acessos nos Últimos 7 Dias';
    protected string $color = 'info';

    protected function getData(): array
    {
        $data = Visita::select(DB::raw('DATE(visitado_em) as data'), DB::raw('count(*) as total'))
            ->where('visitado_em', '>=', now()->subDays(7))
            ->groupBy('data')
            ->orderBy('data')
            ->get();
 
        return [
            'datasets' => [
                [
                    'label' => 'Visitas',
                    'data' => $data->pluck('total')->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn ($item) => Carbon::parse($item->data)->format('d/m'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
