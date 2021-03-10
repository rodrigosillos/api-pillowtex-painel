<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();
            $table->string('book_entry')->nullable();
            $table->string('operation_code')->nullable();
            $table->string('document')->nullable();
            $table->dateTime('due_date');
            $table->string('effected', 10)->nullable();
            $table->string('substituted', 10)->nullable();
            $table->decimal('amount', $precision = 8, $scale = 2)->nullable();
            $table->decimal('commission', $precision = 8, $scale = 2)->nullable();
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
        Schema::dropIfExists('debtors');
    }
}
