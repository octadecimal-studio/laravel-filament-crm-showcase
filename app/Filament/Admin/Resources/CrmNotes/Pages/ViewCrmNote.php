<?php

namespace App\Filament\Admin\Resources\CrmNotes\Pages;

use App\Filament\Admin\Resources\CrmNotes\CrmNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCrmNote extends ViewRecord
{
    protected static string $resource = CrmNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
