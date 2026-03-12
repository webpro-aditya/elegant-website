<?php

namespace Modules\Seo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seo\Database\factories\SeoFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Model
{
    use HasFactory;
    use SoftDeletes;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [ 'meta_title',  'meta_description', 'meta_contents', 'canonical_tag_url', 'model','model_id', 'google_analytics_footer', 'google_analytics_head', 'google_analytics_body'];

    protected $table = 'seo';
    
    protected static function newFactory(): SeoFactory
    {
        //return SeoFactory::new();
    }

    public function modelable()
    {
        return $this->morphTo(__FUNCTION__, 'model', 'model_id');
    }
    
}
