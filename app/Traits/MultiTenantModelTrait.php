<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait MultiTenantModelTrait
{
    public static function bootMultiTenantModelTrait(): void
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $isAdmin = auth()->user()->hasRole('admin');

            static::creating(function (Model $model) use ($isAdmin) {
                if (!$isAdmin) {
                    $model->created_by_id = auth()->id();
                }
            });

            if (!$isAdmin) {
                static::addGlobalScope('created_by_id', function (Builder $builder) {
                    $field = $builder->getModel()->getTable() . '.created_by_id';
                    $builder->where($field, auth()->id())->orWhereNull($field);
                });
            }
        }
    }
}
