<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'state_id', 'country_id',
    ];

    public function state()
    {
        return $this->hasOne(State::class, 'id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'city_id');
    }
}
