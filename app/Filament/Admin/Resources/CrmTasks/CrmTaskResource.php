<?php

namespace App\Filament\Admin\Resources\CrmTasks;

use App\Filament\Admin\Resources\CrmTasks\Pages\CreateCrmTask;
use App\Filament\Admin\Resources\CrmTasks\Pages\EditCrmTask;
use App\Filament\Admin\Resources\CrmTasks\Pages\ListCrmTasks;
use App\Filament\Admin\Resources\CrmTasks\Pages\ViewCrmTask;
use App\Filament\Admin\Resources\CrmTasks\Schemas\CrmTaskForm;
use App\Filament\Admin\Resources\CrmTasks\Schemas\CrmTaskInfolist;
use App\Filament\Admin\Resources\CrmTasks\Tables\CrmTasksTable;
use App\Models\CrmTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrmTaskResource extends Resource
{
    protected static ?string $model = CrmTask::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'CRM';

    protected static ?string $navigationLabel = 'Zadania';

    protected static ?string $modelLabel = 'Zadanie';

    protected static ?string $pluralModelLabel = 'Zadania';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CrmTaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CrmTaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrmTasksTable::configure($table);
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
            'index' => ListCrmTasks::route('/'),
            'create' => CreateCrmTask::route('/create'),
            'view' => ViewCrmTask::route('/{record}'),
            'edit' => EditCrmTask::route('/{record}/edit'),
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
