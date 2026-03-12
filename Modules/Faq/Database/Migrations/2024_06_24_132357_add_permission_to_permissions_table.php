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
        Permission::create(['name' => 'faq_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'faq_create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'faq_update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'faq_delete', 'guard_name' => 'admin']);
    
  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'faq_read')->delete();
        Permission::where('name', 'faq_create')->delete();
        Permission::where('name', 'faq_update')->delete();
        Permission::where('name', 'faq_delete')->delete();
    }
};
