<?php

namespace App\Filament\Admin\Resources\CrmNotes\Schemas;

use App\Models\CrmNote;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CrmNoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('body')
                    ->columnSpanFull(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('related_type')
                    ->placeholder('-'),
                TextEntry::make('related_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (CrmNote $record): bool => $record->trashed()),
            ]);
    }
}
