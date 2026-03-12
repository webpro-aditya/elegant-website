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
        $fields = ["title", "name", "content", "image-dropzone", "status"];
        $fieldsJson = json_encode($fields); 
        ContentCategory::where('slug', 'major-milestones')->update(['fields' => $fieldsJson]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $fields =["title", "name", "content", "status"];
        $fieldsJson = json_encode($fields); 
        ContentCategory::where('slug', 'major-milestones')->update(['fields' => $fieldsJson]);
    }
};
