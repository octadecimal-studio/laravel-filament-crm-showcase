<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;

class ChatCloud extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Workspace';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Chat (Rocket.Chat)';

    protected static ?string $title = 'Chat - komunikacja zespolowa';

    protected static ?string $slug = 'chat';

    protected string $view = 'filament.admin.pages.chat-cloud';

    public string $url = 'https://chat.octadecimal.cloud/';

    public function getViewData(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
