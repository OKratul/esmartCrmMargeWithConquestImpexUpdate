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
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer_models');
            $table->string('query_source');
            $table->string('status');
            $table->longText('query_details',1500);
            $table->string('product_sku')->nullable();
            $table->longText('product_name');
            $table->string('product_quantity');
            $table->string('product_category');
            $table->date('reminder_date')->nullable();
            $table->string('submit_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queries');
    }
};
