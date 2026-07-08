<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'technician_id',
        'check_in_time',
        'check_out_time',
        'check_in_lat',
        'check_in_lng',
        'check_out_lat',
        'check_out_lng',
        'total_hours',
        'device_tamper_flag',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'check_in_lat' => 'float',
        'check_in_lng' => 'float',
        'check_out_lat' => 'float',
        'check_out_lng' => 'float',
        'total_hours' => 'float',
        'device_tamper_flag' => 'boolean',
    ];

    /**
     * Get the job associated with this time log.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the technician associated with this time log.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
