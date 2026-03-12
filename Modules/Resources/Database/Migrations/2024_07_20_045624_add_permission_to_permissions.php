<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create(['name' => 'free_resource_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'free_resource_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'free_resource_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'free_resource_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'free_resource_read')->delete();
        Permission::where('name', 'free_resource_create')->delete();
        Permission::where('name', 'free_resource_update')->delete();
        Permission::where('name', 'free_resource_delete')->delete();
    }
};
