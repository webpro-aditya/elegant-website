<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Settings\Entities\Setting;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Setting::create(['key' => 'mail_mailer', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_host', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_port', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_username', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_password', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_encryption', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_from_address', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'mail_from_name', 'value' => '', 'category' => 'config']);

        Setting::create(['key' => 'twilio_account_sid', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'twilio_auth_token', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'twilio_phone_no', 'value' => '', 'category' => 'config']);

        Setting::create(['key' => 'razorpay_api_key', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'razorpay_api_secret', 'value' => '', 'category' => 'config']);

        Setting::create(['key' => 'aws_access_key_id', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'aws_secret_access_key', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'aws_default_region', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'aws_bucket', 'value' => '', 'category' => 'config']);
        Setting::create(['key' => 'aws_use_path_style_endpoint', 'value' => '', 'category' => 'config']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'mail_mailer')->delete();
        Setting::where('key', 'mail_host')->delete();
        Setting::where('key', 'mail_port')->delete();
        Setting::where('key', 'mail_username')->delete();
        Setting::where('key', 'mail_password')->delete();
        Setting::where('key', 'mail_encryption')->delete();
        Setting::where('key', 'mail_from_address')->delete();
        Setting::where('key', 'mail_from_name')->delete();

        Setting::where('key', 'twilio_account_sid')->delete();
        Setting::where('key', 'twilio_auth_token')->delete();
        Setting::where('key', 'twilio_phone_no')->delete();

        Setting::where('key', 'razorpay_api_key')->delete();
        Setting::where('key', 'razorpay_api_secret')->delete();

        Setting::where('key', 'aws_access_key_id')->delete();
        Setting::where('key', 'aws_secret_access_key')->delete();
        Setting::where('key', 'aws_default_region')->delete();
        Setting::where('key', 'aws_bucket')->delete();
        Setting::where('key', 'aws_use_path_style_endpoint')->delete();
    }
};
