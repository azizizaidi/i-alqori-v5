<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassName extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'feeperhour',
        'allowanceperhour',
    ];

    protected $casts = [
        'feeperhour' => 'decimal:2',
        'allowanceperhour' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the class assignments for this class name.
     */
    public function assignClassTeachers(): BelongsToMany
    {
        return $this->belongsToMany(AssignClassTeacher::class, 'assign_class_teacher_class_name');
    }

    /**
     * Get the fee rates for this class name.
     */
    public function feeRates(): HasMany
    {
        return $this->hasMany(FeeRate::class, 'class_names_id');
    }

    /**
     * Get the register classes for this class name.
     */
    public function registerClasses(): HasMany
    {
        return $this->hasMany(RegisterClass::class, 'class_name_id');
    }

    /**
     * Get the report classes for this class name.
     */
    public function reportClasses(): HasMany
    {
        return $this->hasMany(ReportClass::class, 'class_names_id');
    }

    /**
     * Get formatted fee per hour.
     */
    public function getFormattedFeeAttribute(): string
    {
        return 'RM ' . number_format($this->feeperhour, 2);
    }

    /**
     * Get formatted allowance per hour.
     */
    public function getFormattedAllowanceAttribute(): string
    {
        return 'RM ' . number_format($this->allowanceperhour, 2);
    }
}
