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
        Permission::create(['name' => 'career_applicant_read', 'guard_name' => 'admin']);
        Permission::create(['name' => 'career_applicant_view', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'career_applicant_read')->delete();
        Permission::where('name', 'career_applicant_view')->delete();
    }
};
