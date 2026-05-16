<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResult extends Model
{
    protected $fillable = [
        'user_id', 'test_title', 'score', 'percentage', 'result_data', 'status',
    ];

    protected $casts = [
        'result_data' => 'array',
        'percentage'  => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'completed' => 'green',
            'pending'   => 'orange',
            'failed'    => 'red',
            default     => 'gray',
        };
    }
}
