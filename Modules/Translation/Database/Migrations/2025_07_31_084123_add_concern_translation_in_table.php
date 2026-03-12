<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Translation\Entities\Translation;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if (!Translation::where('key', 'your_concern')->exists()) {
            Translation::create([
                'key' => 'your_concern',
                'value_en' => 'Course Name / Type Your Concern',
                'value_ar' => 'اسم الدورة / أدخل استفسارك'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Translation::where('key', 'your_concern')->delete();
    }
};
