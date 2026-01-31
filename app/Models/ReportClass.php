<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReportClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'registrar_id',
        'class_names_id',
        'date',
        'total_hour',
        'class_names_id_2',
        'date_2',
        'total_hour_2',
        'month',
        'allowance',
        'fee_student',
        'status',
        'note',
        'receipt',
        'allowance_note',
        'transaction_time',
        'bill_code',
        'created_by_id',
        'register_class_id',
    ];

    protected $casts = [
        'date' => 'array',
        'date_2' => 'array',
        'total_hour' => 'integer',
        'total_hour_2' => 'integer',
        'allowance' => 'decimal:2',
        'fee_student' => 'decimal:2',
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the primary class name.
     */
    public function className(): BelongsTo
    {
        return $this->belongsTo(ClassName::class, 'class_names_id');
    }

    /**
     * Get the secondary class name.
     */
    public function className2(): BelongsTo
    {
        return $this->belongsTo(ClassName::class, 'class_names_id_2');
    }

    /**
     * Get the registrar/client.
     */
    public function registrar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    /**
     * Get the teacher who created this report.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Get the register class.
     */
    public function registerClass(): BelongsTo
    {
        return $this->belongsTo(RegisterClass::class, 'register_class_id');
    }

    /**
     * Get history payments for this report.
     */
    public function historyPayments(): HasMany
    {
        return $this->hasMany(HistoryPayment::class, 'report_class_id');
    }

    /**
     * Get formatted status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            0 => 'Belum Bayar',
            1 => 'Dah Bayar',
            2 => 'Dalam Proses Transaksi',
            3 => 'Gagal Bayar',
            4 => 'Dalam Proses',
            5 => 'Yuran Terlebih',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            0 => 'badge-error',
            1 => 'badge-success',
            2 => 'badge-primary',
            3 => 'badge-info',
            4 => 'badge-ghost',
            5 => 'badge-warning',
            default => 'badge-ghost',
        };
    }

    /**
     * Get formatted allowance.
     */
    public function getFormattedAllowanceAttribute(): string
    {
        return $this->allowance ? 'RM ' . number_format($this->allowance, 2) : 'RM 0.00';
    }

    /**
     * Get formatted fee.
     */
    public function getFormattedFeeAttribute(): string
    {
        return $this->fee_student ? 'RM ' . number_format($this->fee_student, 2) : 'RM 0.00';
    }

    /**
     * Get dates as formatted string.
     */
    public function getFormattedDatesAttribute(): string
    {
        if (is_array($this->date)) {
            return implode(', ', $this->date);
        }
        return $this->date ?? '';
    }
}
