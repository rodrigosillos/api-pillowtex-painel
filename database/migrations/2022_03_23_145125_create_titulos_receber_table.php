<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitulosReceberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titulos_receber', function (Blueprint $table) {
            $table->id();
            $table->integer('lancamento');
            $table->string('n_documento', 35);
            $table->integer('tipo_pagto')->nullable();
            $table->dateTime('data_emissao');
            $table->dateTime('data_vencimento');
            $table->dateTime('data_pagamento')->nullable()->index();
            $table->float('valor_inicial', 8, 2);
            $table->float('acres_decres', 8, 2);
            $table->float('valor_pago', 8, 2);
            $table->string('obs', 255);
            $table->integer('filial');
            $table->string('pconta', 60)->nullable();
            $table->boolean('efetuado')->default(0);
            $table->integer('cod');
            $table->string('banco_titulo', 30)->nullable();
            $table->string('agencia', 7)->nullable();
            $table->string('c_c', 30)->nullable();
            $table->boolean('prorrogado')->default(0);
            $table->boolean('devolvido')->default(0);
            $table->boolean('cartorio')->default(0);
            $table->boolean('protesto')->default(0);
            $table->string('tit_banco', 20)->nullable();
            $table->string('carteira', 2)->nullable();
            $table->string('desc_tipo_pgto', 30);
            $table->string('desc_pconta', 60)->nullable();
            $table->string('desc_gerador', 150);
            $table->integer('banco')->nullable();
            $table->string('gerador', 1);
            $table->boolean('substituido')->default(0);
            $table->boolean('baixa')->default(0);
            $table->integer('origem')->nullable()->index();
            $table->string('tipo', 1);
            $table->string('representante_pedido', 200)->nullable();
            $table->integer('representante')->nullable();
            $table->string('representante_cliente', 200)->nullable();
            $table->string('representante_movimento', 200)->nullable();
            $table->string('cliente_nome', 100)->nullable();
            $table->float('valor_comissao', 8, 2)->default(0.00);
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
        Schema::dropIfExists('titulos_receber');
    }
}
