<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_hour',
        'batch',
    ];

    protected $casts = [
        'total_hour' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the class assignments for this package.
     */
    public function assignClassTeachers(): BelongsToMany
    {
        return $this->belongsToMany(AssignClassTeacher::class, 'classpackage_id');
    }

    /**
     * Get the register classes for this package.
     */
    public function registerClasses(): BelongsToMany
    {
        return $this->hasMany(RegisterClass::class, 'class_package_id');
    }

    /**
     * Get formatted total hours.
     */
    public function getFormattedHoursAttribute(): string
    {
        return $this->total_hour . ' jam';
    }
}
