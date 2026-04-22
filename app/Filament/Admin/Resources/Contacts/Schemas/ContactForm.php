<?php

namespace App\Filament\Admin\Resources\Contacts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('Imię')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Nazwisko')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Telefon')
                    ->tel()
                    ->maxLength(50),
                Select::make('company_id')
                    ->label('Firma')
                    ->relationship('company', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('source')
                    ->label('Źródło')
                    ->placeholder('np. referral, website, linkedin')
                    ->maxLength(100),
                TagsInput::make('tags')
                    ->label('Tagi')
                    ->columnSpanFull(),
            ]);
    }
}
