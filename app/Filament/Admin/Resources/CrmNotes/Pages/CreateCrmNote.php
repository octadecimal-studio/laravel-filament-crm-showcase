<?php

namespace App\Filament\Admin\Resources\CrmNotes\Pages;

use App\Filament\Admin\Resources\CrmNotes\CrmNoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmNote extends CreateRecord
{
    protected static string $resource = CrmNoteResource::class;
}
