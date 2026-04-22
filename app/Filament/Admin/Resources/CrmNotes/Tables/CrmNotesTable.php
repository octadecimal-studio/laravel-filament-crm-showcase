<?php

namespace App\Filament\Admin\Resources\CrmNotes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CrmNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('body')
                    ->label('Treść')
                    ->searchable()
                    ->limit(80)
                    ->wrap(),
                TextColumn::make('creator.name')
                    ->label('Utworzył')
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
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
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
