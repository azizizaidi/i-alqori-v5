<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RegisterClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_class',
        'class_type_id',
        'class_name_id',
        'class_package_id',
        'class_numer_id',
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
     * Get the class type.
     */
    public function classType(): BelongsTo
    {
        return $this->belongsTo(ClassType::class, 'class_type_id');
    }

    /**
     * Get the class name.
     */
    public function className(): BelongsTo
    {
        return $this->belongsTo(ClassName::class, 'class_name_id');
    }

    /**
     * Get the class package.
     */
    public function classPackage(): BelongsTo
    {
        return $this->belongsTo(ClassPackage::class, 'class_package_id');
    }

    /**
     * Get the class number.
     */
    public function classNumber(): BelongsTo
    {
        return $this->belongsTo(ClassNumber::class, 'class_numer_id');
    }

    /**
     * Get the report class for this registration.
     */
    public function reportClass(): HasOne
    {
        return $this->hasOne(ReportClass::class, 'register_class_id');
    }

    /**
     * Get formatted fee per hour.
     */
    public function getFormattedFeeAttribute(): string
    {
        return $this->feeperhour ? 'RM ' . number_format($this->feeperhour, 2) : 'N/A';
    }

    /**
     * Get formatted allowance per hour.
     */
    public function getFormattedAllowanceAttribute(): string
    {
        return $this->allowanceperhour ? 'RM ' . number_format($this->allowanceperhour, 2) : 'N/A';
    }
}
