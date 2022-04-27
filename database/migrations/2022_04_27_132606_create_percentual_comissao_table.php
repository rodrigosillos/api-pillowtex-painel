<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePercentualComissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percentual_comissao', function (Blueprint $table) {
            $table->id();
            $table->integer('tabela')->nullable();
            $table->string('cod_divisao', 10);
            $table->string('descricao_divisao', 50);
            $table->float('percentual_comissao', 8, 2);
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
        Schema::dropIfExists('percentual_comissao');
    }
}
