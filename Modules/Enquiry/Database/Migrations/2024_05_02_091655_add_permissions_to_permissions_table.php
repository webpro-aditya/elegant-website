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
        Permission::create(['name' => 'enquiry_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'enquiry_delete', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'enquiry_read')->delete();
        Permission::where('name', 'enquiry_delete')->delete();
    }
};
