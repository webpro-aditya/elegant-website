<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $fillable = ['timezone', 'name'];
}
