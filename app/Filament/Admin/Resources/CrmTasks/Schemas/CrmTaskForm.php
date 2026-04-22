<?php

namespace App\Filament\Admin\Resources\CrmTasks\Schemas;

use App\Models\Company;
use App\Models\Contact;
use App\Models\CrmTask;
use App\Models\Opportunity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CrmTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Tytuł')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Opis')
                    ->rows(4)
                    ->columnSpanFull(),
                DateTimePicker::make('due_at')
                    ->label('Termin')
                    ->seconds(false),
                Select::make('status')
                    ->label('Status')
                    ->options(CrmTask::STATUSES)
                    ->default(CrmTask::STATUS_PENDING)
                    ->required()
                    ->native(false),
                Select::make('assignee_id')
                    ->label('Przypisany do')
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->preload(),
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
