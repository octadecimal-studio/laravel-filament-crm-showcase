<?php

namespace App\Filament\Admin\Resources\Opportunities\Tables;

use App\Models\Opportunity;
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

class OpportunitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stage')
                    ->label('Etap')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Opportunity::STAGES[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Opportunity::STAGE_WON => 'success',
                        Opportunity::STAGE_LOST => 'danger',
                        Opportunity::STAGE_NEGOTIATION => 'warning',
                        Opportunity::STAGE_PROPOSAL => 'info',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Kwota')
                    ->money(fn ($record) => $record->currency ?? 'PLN')
                    ->sortable(),
                TextColumn::make('probability')
                    ->label('Prawd.')
                    ->suffix('%')
                    ->sortable()
                    ->alignEnd(),
                TextColumn::make('close_date')
                    ->label('Data zamknięcia')
                    ->date('Y-m-d')
                    ->sortable(),
                TextColumn::make('company.name')
                    ->label('Firma')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('contact.full_name')
                    ->label('Kontakt')
                    ->searchable(['contacts.first_name', 'contacts.last_name'])
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Utworzono')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('stage')
                    ->label('Etap')
                    ->options(Opportunity::STAGES),
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
