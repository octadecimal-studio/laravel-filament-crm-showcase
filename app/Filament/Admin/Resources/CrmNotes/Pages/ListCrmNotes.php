<?php

namespace App\Filament\Admin\Resources\CrmNotes\Pages;

use App\Filament\Admin\Resources\CrmNotes\CrmNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmNotes extends ListRecords
{
    protected static string $resource = CrmNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
