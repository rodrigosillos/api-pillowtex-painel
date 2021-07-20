<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToInvoicesProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices_product', function (Blueprint $table) {
            $table->decimal('price_applied', $precision = 8, $scale = 2)->nullable();
            $table->decimal('price_gross', $precision = 8, $scale = 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices_product', function (Blueprint $table) {
            Schema::dropIfExists('price_applied');
            Schema::dropIfExists('price_gross');
        });
    }
}
