<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardVendasRepresentanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_vendas_representante', function (Blueprint $table) {
            $table->id();
            $table->integer('representante');
            $table->string('representante_nome', 100);
            $table->string('representante_uf', 2)->nullable();
            $table->decimal('valor_venda', $precision = 15, $scale = 2)->nullable();
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
        Schema::dropIfExists('dashboard_vendas_representante');
    }
}
