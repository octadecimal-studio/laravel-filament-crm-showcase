<?php

namespace App\Filament\Admin\Resources\CrmTasks\Schemas;

use App\Models\CrmTask;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CrmTaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('due_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('assignee.name')
                    ->label('Assignee')
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
                    ->visible(fn (CrmTask $record): bool => $record->trashed()),
            ]);
    }
}
