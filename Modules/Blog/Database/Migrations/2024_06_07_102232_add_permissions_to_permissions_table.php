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
        Permission::create(['name' => 'blog_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_delete', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_category_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_category_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_category_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'blog_category_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'blog_read')->delete();
        Permission::where('name', 'blog_create')->delete();
        Permission::where('name', 'blog_update')->delete();
        Permission::where('name', 'blog_delete')->delete();
        Permission::where('name', 'blog_category_read')->delete();
        Permission::where('name', 'blog_category_create')->delete();
        Permission::where('name', 'blog_category_update')->delete();
        Permission::where('name', 'blog_category_delete')->delete();
    }
};
