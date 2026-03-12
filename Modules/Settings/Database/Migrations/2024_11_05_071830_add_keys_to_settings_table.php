<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Settings\Entities\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::create(['key' => 'lms_link', 'value' => '', 'category' => 'store']);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'lms_link')->delete();
    }
};
