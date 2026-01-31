<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_paid',
        'receipt_paid',
        'paid_by_id',
        'report_class_id',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user who paid.
     */
    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by_id');
    }

    /**
     * Get the report class.
     */
    public function reportClass(): BelongsTo
    {
        return $this->belongsTo(ReportClass::class, 'report_class_id');
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'RM ' . number_format($this->amount_paid, 2);
    }
}
