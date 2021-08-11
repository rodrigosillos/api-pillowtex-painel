<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id();
            $table->string('conta', 30);
            $table->string('numero_lancamento', 30)->unique();
            $table->string('numero_documento', 30);
            $table->dateTime('data_emissao');
            $table->dateTime('data_vencimento');
            $table->dateTime('data_pagamento')->index();
            $table->boolean('efetuado')->default(0);
            $table->boolean('substituido')->default(0);
            $table->boolean('baixa')->default(0);
            $table->decimal('valor_inicial', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('valor_pago', $precision = 8, $scale = 2)->default(0.00);
            $table->decimal('valor_comissao', $precision = 8, $scale = 2)->default(0.00);
            $table->string('filial', 30)->nullable();
            $table->string('origem', 30)->nullable()->index();
            $table->string('tipo', 30)->nullable();
            $table->string('representante', 30)->nullable();
            $table->string('cliente_nome', 100)->nullable();
            $table->string('obs', 100)->nullable();
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
        Schema::dropIfExists('lancamentos');
    }
}
