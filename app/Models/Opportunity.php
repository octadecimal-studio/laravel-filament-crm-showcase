<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Opportunity — a sales deal flowing through pipeline stages.
 */
class Opportunity extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    public const STAGE_NEW = 'new';
    public const STAGE_DISCOVERY = 'discovery';
    public const STAGE_PROPOSAL = 'proposal';
    public const STAGE_NEGOTIATION = 'negotiation';
    public const STAGE_WON = 'won';
    public const STAGE_LOST = 'lost';

    public const STAGES = [
        self::STAGE_NEW => 'Nowa',
        self::STAGE_DISCOVERY => 'Discovery',
        self::STAGE_PROPOSAL => 'Oferta',
        self::STAGE_NEGOTIATION => 'Negocjacje',
        self::STAGE_WON => 'Wygrana',
        self::STAGE_LOST => 'Przegrana',
    ];

    protected $fillable = [
        'name',
        'stage',
        'amount',
        'currency',
        'close_date',
        'contact_id',
        'company_id',
        'probability',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'close_date' => 'date',
        'probability' => 'integer',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks(): MorphMany
    {
        return $this->morphMany(CrmTask::class, 'related');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(CrmNote::class, 'related');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'stage', 'amount', 'currency', 'close_date', 'probability'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
