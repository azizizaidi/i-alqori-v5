<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssignClassTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'assign_class_code',
        'teacher_id',
        'registrar_id',
        'class_name_id',
        'classpackage_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the teacher for this assignment.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the registrar/client for this assignment.
     */
    public function registrar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    /**
     * Get the primary class name.
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
        return $this->belongsTo(ClassPackage::class, 'classpackage_id');
    }

    /**
     * Get all class names for this assignment.
     */
    public function classNames(): BelongsToMany
    {
        return $this->belongsToMany(ClassName::class, 'assign_class_teacher_class_name');
    }

    /**
     * Get all class packages for this assignment.
     */
    public function classPackages(): BelongsToMany
    {
        return $this->belongsToMany(ClassPackage::class, 'classpackage_id');
    }

    /**
     * Get the register class for this assignment.
     */
    public function registerClasses(): HasMany
    {
        return $this->hasMany(RegisterClass::class, 'assign_class_code', 'assign_class_code');
    }

    /**
     * Get teacher name attribute.
     */
    public function getTeacherNameAttribute(): string
    {
        return $this->teacher?->name ?? 'N/A';
    }

    /**
     * Get registrar name attribute.
     */
    public function getRegistrarNameAttribute(): string
    {
        return $this->registrar?->name ?? 'N/A';
    }

    /**
     * Get registrar code attribute.
     */
    public function getRegistrarCodeAttribute(): string
    {
        return $this->registrar?->code ?? 'N/A';
    }

    /**
     * Get classes as formatted string.
     */
    public function getClassesAttribute(): string
    {
        return $this->classNames->pluck('name')->implode(', ');
    }
}
