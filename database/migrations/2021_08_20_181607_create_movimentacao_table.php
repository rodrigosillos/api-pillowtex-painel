<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimentacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacao', function (Blueprint $table) {
            $table->id();
            $table->integer('evento');
            $table->integer('tabela');
            $table->integer('condicoes_pgto');
            $table->integer('ticket');
            $table->integer('conta');
            $table->integer('recibo');
            $table->integer('romaneio');
            $table->date('data');
            $table->integer('fornecedor');
            $table->integer('filial');
            $table->integer('transportadora');
            $table->integer('total', $precision = 15, $scale = 2)->nullable();
            $table->integer('cliente');
            $table->string('cliente_uf', 2);
            $table->integer('representante');
            $table->string('representante_uf', 2);
            $table->integer('qtde');
            $table->integer('valor_final', $precision = 15, $scale = 2)->nullable();
            $table->integer('cod_operacao');
            $table->string('tipo_operacao', 1);
            $table->decimal('cortesia', $precision = 15, $scale = 2)->nullable();
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
        Schema::dropIfExists('movimentacao');
    }
}
