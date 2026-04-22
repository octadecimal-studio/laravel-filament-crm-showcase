<?php

namespace App\Filament\Admin\Resources\CrmTasks\Pages;

use App\Filament\Admin\Resources\CrmTasks\CrmTaskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmTask extends CreateRecord
{
    protected static string $resource = CrmTaskResource::class;
}
