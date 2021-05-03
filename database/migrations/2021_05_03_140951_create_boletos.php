<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->float('valor', 8, 2, true);
            $table->text('codigo_barras');
            $table->date('vencimento');
            $table->boolean('pago');
            $table->string('path');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->unsignedBigInteger('cadastrado_por_user_id');
            $table->foreign('cadastrado_por_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('boletos');
    }
}
