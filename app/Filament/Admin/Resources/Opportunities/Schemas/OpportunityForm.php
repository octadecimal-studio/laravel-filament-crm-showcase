<?php

namespace App\Filament\Admin\Resources\Opportunities\Schemas;

use App\Models\Opportunity;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OpportunityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nazwa')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('stage')
                    ->label('Etap')
                    ->options(Opportunity::STAGES)
                    ->default(Opportunity::STAGE_NEW)
                    ->required()
                    ->native(false),
                TextInput::make('amount')
                    ->label('Kwota')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->default(0.0),
                TextInput::make('currency')
                    ->label('Waluta')
                    ->required()
                    ->length(3)
                    ->default('PLN'),
                TextInput::make('probability')
                    ->label('Prawdopodobieństwo (%)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0),
                DatePicker::make('close_date')
                    ->label('Data zamknięcia')
                    ->native(false),
                Select::make('contact_id')
                    ->label('Kontakt')
                    ->relationship('contact', 'email')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name} ({$record->email})")
                    ->searchable()
                    ->preload(),
                Select::make('company_id')
                    ->label('Firma')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
                Textarea::make('description')
                    ->label('Opis')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
