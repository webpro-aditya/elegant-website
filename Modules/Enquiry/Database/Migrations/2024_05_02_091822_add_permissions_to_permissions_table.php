<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create(['name' => 'brochure_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'brochure_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'brochure_read')->delete();
        Permission::where('name', 'brochure_delete')->delete();
    }
};
