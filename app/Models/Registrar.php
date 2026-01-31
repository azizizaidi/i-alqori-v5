<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registrar extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'phone',
        'address',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the registrar profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classes assigned to this registrar's children.
     */
    public function assignClassTeachers(): HasMany
    {
        return $this->hasMany(AssignClassTeacher::class, 'registrar_id');
    }

    /**
     * Get the students registered under this registrar.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'registrar_id');
    }

    /**
     * Get report classes for this registrar.
     */
    public function reportClasses(): HasMany
    {
        return $this->hasMany(ReportClass::class, 'registrar_id');
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user?->name ?? 'N/A';
    }
}
