<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;

class N8nCloud extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bolt';

    protected static string|\UnitEnum|null $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Automatyzacje (n8n)';

    protected static ?string $title = 'n8n - automatyzacje workflow';

    protected static ?string $slug = 'n8n';

    protected string $view = 'filament.admin.pages.n8n-cloud';

    public string $url = 'https://n8n.octadecimal.cloud/';

    public function getViewData(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
