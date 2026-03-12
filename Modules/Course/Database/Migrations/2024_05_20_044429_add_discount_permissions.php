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
        Permission::create(['name' => 'discount_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'discount_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'discount_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'discount_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'discount_read')->delete();
        Permission::where('name', 'discount_create')->delete();
        Permission::where('name', 'discount_update')->delete();
        Permission::where('name', 'discount_delete')->delete();
    }
};
