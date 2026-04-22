<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

/**
 * CRM Task — to-do linked to a Contact, Company or Opportunity.
 */
class CrmTask extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING => 'Oczekuje',
        self::STATUS_IN_PROGRESS => 'W trakcie',
        self::STATUS_DONE => 'Wykonane',
        self::STATUS_CANCELLED => 'Anulowane',
    ];

    protected $table = 'crm_tasks';

    protected $fillable = [
        'title',
        'description',
        'due_at',
        'status',
        'assignee_id',
        'related_type',
        'related_id',
    ];

    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'due_at', 'assignee_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
