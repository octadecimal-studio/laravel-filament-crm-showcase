<?php

namespace App\Filament\Admin\Resources\CrmNotes\Schemas;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Opportunity;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CrmNoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('body')
                    ->label('Treść')
                    ->required()
                    ->rows(8)
                    ->columnSpanFull(),
                Hidden::make('created_by')
                    ->default(fn () => auth()->id()),
                MorphToSelect::make('related')
                    ->label('Powiązane z')
                    ->types([
                        MorphToSelect\Type::make(Contact::class)
                            ->label('Kontakt')
                            ->titleAttribute('last_name'),
                        MorphToSelect\Type::make(Company::class)
                            ->label('Firma')
                            ->titleAttribute('name'),
                        MorphToSelect\Type::make(Opportunity::class)
                            ->label('Szansa')
                            ->titleAttribute('name'),
                    ])
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]);
    }
}
