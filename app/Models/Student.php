<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'age_stage',
        'note',
        'student_id',
        'registrar_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the registrar/parent that registered this student.
     */
    public function registrar(): BelongsTo
    {
        return $this->belongsTo(Registrar::class, 'registrar_id');
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return $this->user?->name ?? 'N/A';
    }

    /**
     * Get age stage label.
     */
    public function getAgeStageLabelAttribute(): string
    {
        return match ($this->age_stage) {
            'kanak-kanak' => 'Kanak-kanak',
            'remaja' => 'Remaja',
            'dewasa' => 'Dewasa',
            default => 'Tidak Diketahui',
        };
    }
}
