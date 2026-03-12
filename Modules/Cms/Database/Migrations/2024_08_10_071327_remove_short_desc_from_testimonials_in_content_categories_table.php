<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\ContentCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fields = [
            "name",
            "title",
            "short_desc",
            "course_id",
            "thumbnail",
            "image-dropzone",
            "status"
        ];
        $fieldsJson = json_encode($fields); 
        ContentCategory::where('slug', 'testimonials')->update(['fields' => $fieldsJson]);
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $fields = [
            "name",
            "title",
            "content",
            "short_desc",
            "course_id",
            "thumbnail",
            "description",
            "image-dropzone",
            "status"
        ];
        $fieldsJson = json_encode($fields); 
        ContentCategory::where('slug', 'testimonials')->update(['fields' => $fieldsJson]);
    }
};
