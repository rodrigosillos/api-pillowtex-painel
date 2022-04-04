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
            $table->integer('cod_operacao');
            $table->string('tipo_operacao', 1);
            $table->integer('romaneio');
            $table->integer('ticket')->nullable();
            $table->dateTime('data_emissao');
            $table->integer('cliente');
            $table->string('cliente_codigo', 12);
            $table->string('cliente_nome', 60);
            $table->string('cliente_estado', 2)->nullable();
            $table->integer('representante')->nullable();
            $table->string('representante_cod', 15)->nullable();
            $table->string('representante_nome', 120)->nullable();
            $table->float('valor_comissao_representante', 8, 2)->default(0.00);
            $table->integer('representante_cliente')->nullable();
            $table->string('representante_cliente_cod', 15)->nullable();
            $table->string('representante_cliente_nome', 120)->nullable();
            $table->float('valor_comissao_representante_cliente', 8, 2)->default(0.00);
            $table->float('valor_comissao', 8, 2)->default(0.00);
            $table->integer('evento');
            $table->integer('tabela')->nullable();
            $table->integer('filial');
            $table->float('cortesia', 8, 2)->nullable();
            $table->float('comissao_f', 8, 2)->nullable();
            $table->float('comissao_g', 8, 2)->nullable();
            $table->float('comissao_r', 8, 2)->nullable();
            $table->float('comissao_r_cli', 8, 2)->nullable();
            $table->float('comissao_s', 8, 2)->nullable();
            $table->integer('tipo_comissao_f')->nullable();
            $table->integer('tipo_comissao_r')->nullable();
            $table->integer('tipo_comissao_r_cli')->nullable();
            $table->integer('tipo_comissao_r_ori')->nullable();
            $table->integer('tipo_consignacao')->nullable();
            $table->float('valor_faturamento_representante_cliente', 8, 2)->nullable();
            $table->float('valor_faturamento_representante', 8, 2)->nullable();
            $table->float('valor_faturamento', 8, 2)->nullable();
            $table->float('valor_final', 8, 2);
            $table->float('total', 8, 2);
            $table->integer('qtde');
            $table->string('tipo', 2);
            $table->boolean('cancelada')->default(0);
            $table->string('notas', 50)->nullable();
            $table->integer('pedidov')->nullable();
            $table->string('cod_pedidov', 20)->nullable();
            $table->string('tipo_pedido', 30);
            $table->integer('condicoes_pgto')->nullable();
            $table->boolean('oculto')->default(0);
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
