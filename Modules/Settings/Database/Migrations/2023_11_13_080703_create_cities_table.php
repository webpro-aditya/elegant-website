<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id('id');
            $table->timestamps();
            $table->softDeletes();
            $table->smallInteger('country_id');
            $table->smallInteger('state_id');
            $table->string('name', 100);
        });
    }

    public function down()
    {
        Schema::drop('cities');
    }
};
