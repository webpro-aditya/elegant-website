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
        Permission::create(['name' => 'translation_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'translation_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'translation_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'translation_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'translation_read')->delete();
        Permission::where('name', 'translation_create')->delete();
        Permission::where('name', 'translation_update')->delete();
        Permission::where('name', 'translation_delete')->delete();
    }
};
