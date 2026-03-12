<?php

namespace Modules\Subscriber\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Subscriber\Database\factories\SubscriberFactory;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['email','status'];

    protected $table = 'subscribers';

    protected $dates = ['deleted_at'];
    
    protected static function newFactory(): SubscriberFactory
    {
        //return SubscriberFactory::new();
    }
}
