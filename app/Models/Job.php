<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_phone',
        'service_address',
        'latitude',
        'longitude',
        'issue_description',
        'status',
        'assigned_to',
        'scheduled_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'scheduled_at' => 'datetime',
    ];

    /**
     * Get the technician assigned to this job.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the time logs for this job.
     */
    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class);
    }
}
