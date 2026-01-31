<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'phone',
        'address',
        'position',
        'sex',
        'bank_name',
        'account_bank',
    ];

    protected $casts = [
        'phone' => 'integer',
        'account_bank' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the teacher profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classes assigned to this teacher.
     */
    public function assignClassTeachers(): HasMany
    {
        return $this->hasMany(AssignClassTeacher::class, 'teacher_id');
    }

    /**
     * Get the report classes created by this teacher.
     */
    public function reportClasses(): HasMany
    {
        return $this->hasMany(ReportClass::class, 'created_by_id');
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user?->name ?? 'N/A';
    }
}
