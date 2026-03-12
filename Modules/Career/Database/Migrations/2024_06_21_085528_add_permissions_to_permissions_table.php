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
        Permission::create(['name' => 'career_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_delete', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_category_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_category_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_category_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_category_delete', 'guard_name' => 'admin']);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'career_read')->delete();
        Permission::where('name', 'career_create')->delete();
        Permission::where('name', 'career_update')->delete();
        Permission::where('name', 'career_delete')->delete();
        Permission::where('name', 'career_category_read')->delete();
        Permission::where('name', 'career_category_create')->delete();
        Permission::where('name', 'career_category_update')->delete();
        Permission::where('name', 'career_category_delete')->delete();
    }
};
