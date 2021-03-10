<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_product', function (Blueprint $table) {
            $table->id();
            $table->string('operation_code')->nullable();
            $table->string('document')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('invoice')->nullable();
            $table->integer('product_id');
            $table->string('product_name')->nullable();
            $table->string('division_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('division_description')->nullable();
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('discount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_product');
    }
}
