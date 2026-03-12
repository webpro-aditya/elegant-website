<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Settings\Entities\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
            'phone' => '+971 4 399 7800',
            'email' => 'info@elegant-training.aem',
            'company_address_line1_en' => 'Office Number 620, AB Center, Beside Ibis Hotel,',
            'company_address_line2_en' => 'Al Barsha 1 Near Mashreq Metro Station, Sheikh Zayed Road, Dubai, UAE',
            'company_description_en' => 'Elegant Professional and Management Development is a leading training center in Dubai, U.A.E. We specialize in affordable, effective, and qualitative face-to-face training in a variety of courses to meet the needs of today’s corporate life.'
        ];

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            }
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Implement the down method to revert the values, if needed
        $settings = [
            'phone' => '',
            'email' => '',
            'company_address_line1_en' => '',
            'company_address_line2_en' => '',
            'company_description_en' => ''
        ];

        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            }
        }
    }
};
