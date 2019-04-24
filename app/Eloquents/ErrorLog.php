<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorLog extends Model
{
    /** @var array */
    protected $fillable = [
        'status',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function accessPoint(): BelongsTo
    {
        return $this->belongsTo(AccessPoint::class);
    }

    public function scopeToday(Builder $builder): Builder
    {
        return $builder->whereBetween('created_at', [today(), today()->endOfDay()]);
    }

    /**
     * @return bool
     */
    public function hasTodayError(): bool
    {
        return $this->query()->today()->exists();
    }
}
