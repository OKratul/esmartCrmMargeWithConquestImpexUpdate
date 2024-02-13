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
        Schema::create('query_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('query_id');
            $table->foreign('query_id')->references('id')->on('queries')->onDelete('cascade');
            $table->date('date');
            $table->longText('notes');
            $table->string('user_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('query_notes');
    }
};
