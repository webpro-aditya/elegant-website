<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create(['name' => 'course_category_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'course_category_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'course_category_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'course_category_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'course_category_read')->delete();
        Permission::where('name', 'course_category_create')->delete();
        Permission::where('name', 'course_category_update')->delete();
        Permission::where('name', 'course_category_delete')->delete();
    }
};
