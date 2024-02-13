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
        Schema::create('conquest_invoices', function (Blueprint $table) {
            $table->id();
            $table-> string('invoice_number')->unique();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('conquest_customers')->onDelete('cascade');
            $table->string('product_id');
            $table->string('quantity');
            $table->string('unit_price');
            $table->string('total_price');
            $table->string('all_total_price');
            $table->string('delivery_charge');
            $table->string('paid');
            $table->string('due');
            $table->string('discount');
            $table->string('extra_name');
            $table->string('extra_price');
            $table->string('status');
            $table->string('warranty');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conquest_invoices');
    }
};
