<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Database\factories\DiscountCodeFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCode extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'code', 'discount_percentage', 'valid_from', 'valid_to', 'attempt_per_user', 'status'];

    protected static function newFactory(): DiscountCodeFactory
    {
        //return DiscountCodeFactory::new();
    }
}
