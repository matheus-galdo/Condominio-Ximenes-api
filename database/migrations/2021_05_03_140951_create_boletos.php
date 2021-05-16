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
            $table->date('data_pagamento')->nullable();
            $table->boolean('pago');
            $table->string('path');
            $table->foreignId('apartamento_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('cadastrado_por_user_id')->constrained('users')->default(0);
            $table->softDeletes();
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
