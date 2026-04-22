<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Opportunity;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OpportunityPipelineWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Pipeline szans sprzedażowych';

    protected function getStats(): array
    {
        $stats = [];

        foreach (Opportunity::STAGES as $stageKey => $stageLabel) {
            $query = Opportunity::query()->where('stage', $stageKey);
            $count = (clone $query)->count();
            $sum = (float) (clone $query)->sum('amount');

            $color = match ($stageKey) {
                Opportunity::STAGE_WON => 'success',
                Opportunity::STAGE_LOST => 'danger',
                Opportunity::STAGE_NEGOTIATION => 'warning',
                Opportunity::STAGE_PROPOSAL => 'info',
                default => 'gray',
            };

            $stats[] = Stat::make($stageLabel, $count)
                ->description(number_format($sum, 2, ',', ' ') . ' PLN')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($color);
        }

        return $stats;
    }
}
