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
        Permission::create(['name' => 'gallery_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'gallery_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'gallery_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'gallery_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'gallery_read')->delete();
        Permission::where('name', 'gallery_create')->delete();
        Permission::where('name', 'gallery_update')->delete();
        Permission::where('name', 'gallery_delete')->delete();
    }
};
