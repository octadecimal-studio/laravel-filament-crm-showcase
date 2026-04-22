<?php

namespace App\Filament\Admin\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('domain')
                    ->label('Domena')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('industry')
                    ->label('Branża')
                    ->searchable()
                    ->badge()
                    ->toggleable(),
                TextColumn::make('size')
                    ->label('Wielkość')
                    ->toggleable(),
                TextColumn::make('country')
                    ->label('Kraj')
                    ->toggleable(),
                TextColumn::make('contacts_count')
                    ->label('Kontakty')
                    ->counts('contacts')
                    ->sortable(),
                TextColumn::make('opportunities_count')
                    ->label('Szanse')
                    ->counts('opportunities')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Utworzono')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
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
