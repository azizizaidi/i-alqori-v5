<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function (Model $model) {
            self::audit('Created', $model);
        });

        static::updated(function (Model $model) {
            $model->attributes = array_merge($model->getChanges(), ['id' => $model->id]);
            self::audit('Updated', $model);
        });

        static::deleted(function (Model $model) {
            self::audit('Deleted', $model);
        });
    }

    protected static function audit(string $description, Model $model): void
    {
        AuditLog::create([
            'description' => $description,
            'subject_id' => $model->id ?? null,
            'subject_type' => get_class($model),
            'user_id' => auth()->id() ?? null,
            'properties' => $model->getAttributes(),
            'host' => request()->ip() ?? null,
        ]);
    }
}
