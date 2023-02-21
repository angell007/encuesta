<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContableSalarioSubsidioTransporteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contable_salario_subsidio_transporte', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concepto');
            $table->string('cuenta_contable');
            $table->string('contrapartida')->nullable();
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('contable_salario_subsidio_transporte');
    }
}
