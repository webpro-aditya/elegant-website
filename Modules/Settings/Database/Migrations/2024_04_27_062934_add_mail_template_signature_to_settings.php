<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Entities\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::create(['key' => 'signature', 'value' => '', 'category' => 'store']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'signature')->delete();
    }
};
