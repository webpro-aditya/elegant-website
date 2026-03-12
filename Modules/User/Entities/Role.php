<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    protected static function booted()
    {
        static::addGlobalScope('withoutSuper', function (Builder $builder) {
            $builder->where('name', '!=', 'super_privilege');
        });
    }

    protected $appends = ['name_display'];

    public function getNameDisplayAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->name));
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = Str::lower(Str::replace(' ', '_', $name));
    }
}
