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
        Permission::create(['name' => 'venue_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'venue_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'venue_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'venue_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'venue_read')->delete();
        Permission::where('name', 'venue_create')->delete();
        Permission::where('name', 'venue_update')->delete();
        Permission::where('name', 'venue_delete')->delete();
    }
};
