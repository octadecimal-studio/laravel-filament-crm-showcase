<?php

namespace App\Filament\Admin\Resources\Opportunities\Schemas;

use App\Models\Opportunity;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OpportunityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('stage')
                    ->badge(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('currency'),
                TextEntry::make('close_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('contact.id')
                    ->label('Contact')
                    ->placeholder('-'),
                TextEntry::make('company.name')
                    ->label('Company')
                    ->placeholder('-'),
                TextEntry::make('probability')
                    ->numeric(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Opportunity $record): bool => $record->trashed()),
            ]);
    }
}
