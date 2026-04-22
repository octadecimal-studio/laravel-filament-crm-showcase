<?php

namespace App\Filament\Admin\Widgets;

use App\Models\CrmTask;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TasksDueSoonWidget extends TableWidget
{
    protected static ?string $heading = 'Zadania z terminem w najbliższych 7 dniach';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => CrmTask::query()
                ->with('assignee')
                ->whereNotIn('status', [CrmTask::STATUS_DONE, CrmTask::STATUS_CANCELLED])
                ->whereNotNull('due_at')
                ->where('due_at', '<=', now()->addDays(7))
                ->orderBy('due_at'))
            ->paginated(false)
            ->columns([
                TextColumn::make('title')
                    ->label('Tytuł')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => CrmTask::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        CrmTask::STATUS_IN_PROGRESS => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('due_at')
                    ->label('Termin')
                    ->dateTime('Y-m-d H:i')
                    ->color(fn ($record): string => $record->due_at?->isPast() ? 'danger' : 'gray'),
                TextColumn::make('assignee.name')
                    ->label('Przypisany do'),
            ]);
    }
}
