<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable FK checks to safely truncate/drop
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate in correct order (children → parent)
        DB::statement('TRUNCATE TABLE telescope_entries_tags');
        DB::statement('TRUNCATE TABLE telescope_monitoring');
        DB::statement('TRUNCATE TABLE telescope_entries');

        // Drop tables (again, children first)
        Schema::dropIfExists('telescope_entries_tags');
        Schema::dropIfExists('telescope_monitoring');
        Schema::dropIfExists('telescope_entries');

        // Re-enable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        // optional: no rollback needed
    }
};
