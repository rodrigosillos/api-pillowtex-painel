<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('operation_code')->nullable();
            $table->string('document')->nullable();
            $table->dateTime('issue_date');
            $table->integer('client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_address')->nullable();
            $table->integer('agent_id')->nullable();
            $table->string('agent_name')->nullable();
            $table->integer('price_list')->nullable();
            $table->decimal('amount', $precision = 8, $scale = 2)->nullable();
            $table->string('invoice_type')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
