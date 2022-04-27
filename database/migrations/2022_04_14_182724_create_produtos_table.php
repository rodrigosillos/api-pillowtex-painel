<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_operacao');
            $table->integer('produto');
            $table->string('cod_produto', 60);
            $table->string('descricao1', 100);
            $table->integer('divisao');
            $table->string('cod_divisao', 10);
            $table->string('descricao_divisao', 50);
            $table->integer('cor');
            $table->integer('estampa');
            $table->string('tamanho', 5);
            $table->integer('quantidade');
            $table->float('preco', 8, 2)->default(0.00);
            $table->float('ipi', 8, 2)->default(0.00);
            $table->integer('pedido');
            $table->string('unidade', 5);
            $table->integer('nota');
            $table->float('preco_aplicado', 8, 2)->default(0.00);
            $table->float('desconto', 8, 2)->default(0.00);
            $table->float('preco_bruto', 8, 2)->default(0.00);
            $table->float('valor_comissao', 8, 2)->default(0.00);
            $table->float('percentual_comissao', 8, 2)->default(0.00);
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
        Schema::dropIfExists('produtos');
    }
}
