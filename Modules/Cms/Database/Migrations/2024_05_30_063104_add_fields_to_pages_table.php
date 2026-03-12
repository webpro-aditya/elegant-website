<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Cms\Entities\Page;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fields = ['name', 'title', 'short_desc', 'content', 'description', 'link','file', 'status', 'image-dropzone', 'thumbnail'];
        $jsonFields = json_encode($fields);
        Page::query()->update(['fields' => $jsonFields]);
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Page::query()->update(['fields' => null]);
    }
};
