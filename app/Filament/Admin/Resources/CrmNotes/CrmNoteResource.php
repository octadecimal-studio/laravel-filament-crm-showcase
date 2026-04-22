<?php

namespace App\Filament\Admin\Resources\CrmNotes;

use App\Filament\Admin\Resources\CrmNotes\Pages\CreateCrmNote;
use App\Filament\Admin\Resources\CrmNotes\Pages\EditCrmNote;
use App\Filament\Admin\Resources\CrmNotes\Pages\ListCrmNotes;
use App\Filament\Admin\Resources\CrmNotes\Pages\ViewCrmNote;
use App\Filament\Admin\Resources\CrmNotes\Schemas\CrmNoteForm;
use App\Filament\Admin\Resources\CrmNotes\Schemas\CrmNoteInfolist;
use App\Filament\Admin\Resources\CrmNotes\Tables\CrmNotesTable;
use App\Models\CrmNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrmNoteResource extends Resource
{
    protected static ?string $model = CrmNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'CRM';

    protected static ?string $navigationLabel = 'Notatki';

    protected static ?string $modelLabel = 'Notatka';

    protected static ?string $pluralModelLabel = 'Notatki';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'body';

    public static function form(Schema $schema): Schema
    {
        return CrmNoteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CrmNoteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrmNotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCrmNotes::route('/'),
            'create' => CreateCrmNote::route('/create'),
            'view' => ViewCrmNote::route('/{record}'),
            'edit' => EditCrmNote::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
