<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * Company entity — represents a B2B account in CRM.
 */
class Company extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'domain',
        'industry',
        'size',
        'country',
        'notes',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class);
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
            ->logOnly(['name', 'domain', 'industry', 'size', 'country'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
