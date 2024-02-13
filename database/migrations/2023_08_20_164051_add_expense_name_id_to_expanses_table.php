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
        Schema::table('expanses', function (Blueprint $table) {
            $table->unsignedBigInteger('expense_name_id');
            $table->foreign('expense_name_id')->references('id')->on('expense_names');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expanses', function (Blueprint $table) {
            //
        });
    }
};
