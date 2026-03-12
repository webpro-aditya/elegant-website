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
        Permission::create(['name' => 'course_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'course_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'course_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'course_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'course_read')->delete();
        Permission::where('name', 'course_create')->delete();
        Permission::where('name', 'course_update')->delete();
        Permission::where('name', 'course_delete')->delete();
    }
};
