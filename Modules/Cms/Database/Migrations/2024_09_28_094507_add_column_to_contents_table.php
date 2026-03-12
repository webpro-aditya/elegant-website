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
        Schema::table('contents', function (Blueprint $table) {
            $table->string('phone_number')->after('image_title')->index()->nullable();
            $table->string('email')->after('image_title')->index()->nullable();
        });

        $contentCategory = ContentCategory::where('slug', 'contact-information')->first();

        if ($contentCategory) {
            $fields = json_decode($contentCategory->fields, true);

            if (!is_array($fields)) {
                $fields = [];
            }

            $fields = [
                'title',
                'name',
                'description',
                'email',
                'phone_number',
                'link',
                'status'
            ];

            $contentCategory->fields = json_encode($fields);
            $contentCategory->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('phone_number');
        });

        $contentCategory = ContentCategory::where('slug', 'contact-information')->first();

        if ($contentCategory) {
            $fields = json_decode($contentCategory->fields, true);

            if (!is_array($fields)) {
                $fields = [];
            }

            $fields = [
                "title",
                "name",
                "description",
                "content",
                "short_desc",
                "link",
                "thumbnail",
                "status"
            ];

            $contentCategory->fields = json_encode($fields);
            $contentCategory->save();
        }
    }
};
