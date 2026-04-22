<?php

namespace App\Filament\Admin\Resources\Opportunities;

use App\Filament\Admin\Resources\Opportunities\Pages\CreateOpportunity;
use App\Filament\Admin\Resources\Opportunities\Pages\EditOpportunity;
use App\Filament\Admin\Resources\Opportunities\Pages\ListOpportunities;
use App\Filament\Admin\Resources\Opportunities\Pages\ViewOpportunity;
use App\Filament\Admin\Resources\Opportunities\Schemas\OpportunityForm;
use App\Filament\Admin\Resources\Opportunities\Schemas\OpportunityInfolist;
use App\Filament\Admin\Resources\Opportunities\Tables\OpportunitiesTable;
use App\Models\Opportunity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OpportunityResource extends Resource
{
    protected static ?string $model = Opportunity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|\UnitEnum|null $navigationGroup = 'CRM';

    protected static ?string $navigationLabel = 'Szanse sprzedaży';

    protected static ?string $modelLabel = 'Szansa';

    protected static ?string $pluralModelLabel = 'Szanse sprzedaży';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OpportunityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OpportunityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OpportunitiesTable::configure($table);
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
            'index' => ListOpportunities::route('/'),
            'create' => CreateOpportunity::route('/create'),
            'view' => ViewOpportunity::route('/{record}'),
            'edit' => EditOpportunity::route('/{record}/edit'),
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
