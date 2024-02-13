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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer_models');
            $table->json('products');
            $table->string('offer_validity')->nullable();
            $table->string('warranty');
            $table->string('payment_type');
            $table->string('vat_tax')->nullable();
            $table->string('delivery_term')->nullable();
            $table->longText('other_condition')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('delivery_charge')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('extra_charge_name')->nullable();
            $table->string('extra_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
