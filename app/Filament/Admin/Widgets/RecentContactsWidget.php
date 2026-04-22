<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Contact;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Database\Eloquent\Builder;

class RecentContactsWidget extends TableWidget
{
    protected static ?string $heading = 'Ostatnie kontakty';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Contact::query()->with('company')->latest()->limit(10))
            ->paginated(false)
            ->columns([
                TextColumn::make('last_name')
                    ->label('Nazwisko')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Imię')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable(),
                TextColumn::make('company.name')
                    ->label('Firma'),
                TextColumn::make('created_at')
                    ->label('Dodano')
                    ->since(),
            ]);
    }
}
