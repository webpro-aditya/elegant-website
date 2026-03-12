<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\ContentCategory;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $contentCategory = ContentCategory::where('slug', 'testimonials')->first();

        if ($contentCategory) {
            $fields = json_decode($contentCategory->fields, true);

            if (!is_array($fields)) {
                $fields = [];
            }

            $fields = ['name', 'title', 'content', 'short_desc', 'course_id', 'thumbnail', 'description', 'image-dropzone', 'status'];

            $contentCategory->fields = json_encode($fields);
            $contentCategory->save();
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $contentCategory = ContentCategory::where('slug', 'testimonials')->first();

        if ($contentCategory) {
            $fields = json_decode($contentCategory->fields, true);

            if (!is_array($fields)) {
                $fields = [];
            }

            $fields = ['name', 'title', 'content', 'short_desc', 'thumbnail', 'description', 'image-dropzone', 'status'];

            $contentCategory->fields = json_encode($fields);
            $contentCategory->save();
        }
    }
};
