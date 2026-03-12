<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Cms\Entities\Page;
use Illuminate\Support\Str;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Page::create(['title' => 'HOME', 'slug' => Str::slug('HOME', '-'), 'section' => 'web']);
        Page::create(['title' => 'ABOUT US', 'slug' => Str::slug('ABOUT US', '-'), 'section' => 'web']);
        Page::create(['title' => 'CONTACT US', 'slug' => Str::slug('CONTACT US', '-'), 'section' => 'web']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Page::where('title', 'HOME')->delete();
        Page::where('title', 'ABOUT US')->delete();
        Page::where('title', 'CONTACT US')->delete();
        Page::where('title', 'INSTRUCTOR LED LEARNING')->delete();
        Page::where('title', 'E-LEARNING')->delete();
    }
};
