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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->string('customer_name');
            $table->timestamp('order_date');
            $table->decimal('grand_total',16,2)->default(0);
            $table->timestamps();
        });

        Schema::create('order_items', function(Blueprint $table){
            $table->id();
            $table->integer('order_id');
            $table->string('product_name');
            $table->decimal('price',16,2)->default(0);
            $table->decimal('qty', 16,2)->default(0);
            $table->decimal('sub_total',16,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_items');
    }
};
