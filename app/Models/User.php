<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'code',
        'phone',
        'theme',
        'theme_color',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the teacher profile for this user.
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Get the registrar profile for this user.
     */
    public function registrar()
    {
        return $this->hasOne(Registrar::class);
    }

    /**
     * Get the student profile for this user.
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'student_id');
    }

    /**
     * Get classes assigned as teacher.
     */
    public function teacherClasses()
    {
        return $this->hasMany(AssignClassTeacher::class, 'teacher_id');
    }

    /**
     * Get classes assigned as registrar/client.
     */
    public function registrarClasses()
    {
        return $this->hasMany(AssignClassTeacher::class, 'registrar_id');
    }

    /**
     * Get report classes created by this user.
     */
    public function reportClassesCreated()
    {
        return $this->hasMany(ReportClass::class, 'created_by_id');
    }

    /**
     * Get report classes for this registrar.
     */
    public function reportClasses()
    {
        return $this->hasMany(ReportClass::class, 'registrar_id');
    }

    /**
     * Get tasks assigned to this user.
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_id');
    }

    /**
     * Check if user is admin (role 1).
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is teacher (role 2).
     */
    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    /**
     * Check if user is client/registrar (role 4).
     */
    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    /**
     * Get primary role name.
     */
    public function getPrimaryRoleAttribute(): string
    {
        return $this->getRoleNames()->first() ?? 'user';
    }

    /**
     * Get theme mode class.
     */
    public function getThemeClassAttribute(): string
    {
        return $this->theme === 'dark' ? 'dark' : '';
    }
}
