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
        Schema::create('conquest_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historable_id');
            $table->string('historable_type');
            $table->integer('previous_stock');
            $table->integer('updated_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conquest_histories');
    }
};
