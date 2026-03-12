<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Permission::create(['name' => 'topic_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'topic_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'topic_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'topic_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'topic_read')->delete();
        Permission::where('name', 'topic_create')->delete();
        Permission::where('name', 'topic_update')->delete();
        Permission::where('name', 'topic_delete')->delete();
    }
};
