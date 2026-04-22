<?php

namespace App\Filament\Admin\Resources\CrmTasks\Tables;

use App\Models\CrmTask;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CrmTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tytuł')
                    ->searchable()
                    ->sortable()
                    ->limit(60),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => CrmTask::STATUSES[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        CrmTask::STATUS_DONE => 'success',
                        CrmTask::STATUS_IN_PROGRESS => 'warning',
                        CrmTask::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('due_at')
                    ->label('Termin')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                TextColumn::make('assignee.name')
                    ->label('Przypisany do')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('related_type')
                    ->label('Typ powiązania')
                    ->formatStateUsing(fn (?string $state): string => match (class_basename((string) $state)) {
                        'Contact' => 'Kontakt',
                        'Company' => 'Firma',
                        'Opportunity' => 'Szansa',
                        default => '—',
                    })
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Utworzono')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('due_at', 'asc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(CrmTask::STATUSES),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
