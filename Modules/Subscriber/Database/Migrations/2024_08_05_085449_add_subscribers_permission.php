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
        Permission::create(['name' => 'subscriber_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'subscriber_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'subscriber_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'subscriber_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'subscriber_read')->delete();
        Permission::where('name', 'subscriber_create')->delete();
        Permission::where('name', 'subscriber_update')->delete();
        Permission::where('name', 'subscriber_delete')->delete();
    }
};
