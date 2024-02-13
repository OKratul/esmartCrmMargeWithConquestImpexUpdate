<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('device_header')->nullable();
            $table->string('ip');
            $table->string('location');
            $table->string('device_name');
            $table->string('platform');
            $table->string('browser');
            $table->string('device');
            $table->dateTime('login_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_infos');
    }
};
