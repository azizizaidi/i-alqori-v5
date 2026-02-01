<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait YourClassTrait
{
    public static function bootYourClassTrait(): void
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $isAdmin = auth()->user()->hasRole('admin');

            static::creating(function (Model $model) use ($isAdmin) {
                if (!$isAdmin) {
                    $model->registrar_id = auth()->id();
                }
            });

            if (!$isAdmin) {
                static::addGlobalScope('registrar_id', function (Builder $builder) {
                    $field = $builder->getQuery()->from . '.registrar_id';
                    $builder->where($field, auth()->id())->orWhereNull($field);
                });
            }
        }
    }
}
