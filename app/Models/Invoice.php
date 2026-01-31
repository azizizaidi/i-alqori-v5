<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student',
        'registrar',
        'teacher',
        'class',
        'total_hour',
        'amount_fee',
        'date_class',
        'fee_perhour',
    ];

    protected $casts = [
        'total_hour' => 'integer',
        'amount_fee' => 'decimal:2',
        'fee_perhour' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'RM ' . number_format($this->amount_fee, 2);
    }

    /**
     * Get formatted fee per hour.
     */
    public function getFormattedFeePerHourAttribute(): string
    {
        return 'RM ' . number_format($this->fee_perhour, 2);
    }
}
