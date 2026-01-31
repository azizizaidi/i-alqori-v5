<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_names_id',
        'total_hours_min',
        'total_hours_max',
        'feeperhour',
    ];

    protected $casts = [
        'total_hours_min' => 'integer',
        'total_hours_max' => 'integer',
        'feeperhour' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the class name.
     */
    public function className(): BelongsTo
    {
        return $this->belongsTo(ClassName::class, 'class_names_id');
    }

    /**
     * Get formatted fee per hour.
     */
    public function getFormattedFeeAttribute(): string
    {
        return 'RM ' . number_format($this->feeperhour, 2);
    }

    /**
     * Get hours range as string.
     */
    public function getHoursRangeAttribute(): string
    {
        return $this->total_hours_min . ' - ' . $this->total_hours_max . ' jam';
    }
}
