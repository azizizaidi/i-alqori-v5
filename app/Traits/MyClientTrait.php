<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait MyClientTrait
{
    public static function bootMyClientTrait(): void
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $isAdmin = auth()->user()->hasRole(['admin', 'client']);

            static::creating(function (Model $model) use ($isAdmin) {
                if (!$isAdmin) {
                    $model->teacher_id = auth()->id();
                }
            });

            if (!$isAdmin) {
                static::addGlobalScope('teacher_id', function (Builder $builder) {
                    $field = $builder->getQuery()->from . '.teacher_id';
                    $builder->where($field, auth()->id())->orWhereNull($field);
                });
            }
        }
    }
}
