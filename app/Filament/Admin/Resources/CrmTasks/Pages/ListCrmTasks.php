<?php

namespace App\Filament\Admin\Resources\CrmTasks\Pages;

use App\Filament\Admin\Resources\CrmTasks\CrmTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmTasks extends ListRecords
{
    protected static string $resource = CrmTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
