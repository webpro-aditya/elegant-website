<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Translation\Entities\Translation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Translation::where('key', 'top_companies_hiring_in_india')
            ->update(['key' => 'top_companies_hiring_in_dubai']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Translation::where('key', 'top_companies_hiring_in_dubai')
            ->update(['key' => 'top_companies_hiring_in_india']);
    }
};
