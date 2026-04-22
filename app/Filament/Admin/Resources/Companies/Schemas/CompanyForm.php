<?php

namespace App\Filament\Admin\Resources\Companies\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompanyForm
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
                TextInput::make('domain')
                    ->label('Domena')
                    ->placeholder('example.com')
                    ->maxLength(255),
                TextInput::make('industry')
                    ->label('Branża')
                    ->maxLength(100),
                Select::make('size')
                    ->label('Wielkość')
                    ->options([
                        '1-10' => '1-10',
                        '11-50' => '11-50',
                        '51-200' => '51-200',
                        '201-500' => '201-500',
                        '500+' => '500+',
                    ]),
                TextInput::make('country')
                    ->label('Kraj (ISO2)')
                    ->length(2)
                    ->placeholder('PL'),
                Textarea::make('notes')
                    ->label('Notatki')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
