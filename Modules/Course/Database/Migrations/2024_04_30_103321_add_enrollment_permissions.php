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
        Permission::create(['name' => 'enrollment_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'enrollment_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'enrollment_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'enrollment_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'enrollment_read')->delete();
        Permission::where('name', 'enrollment_create')->delete();
        Permission::where('name', 'enrollment_update')->delete();
        Permission::where('name', 'enrollment_delete')->delete();
    }
};
