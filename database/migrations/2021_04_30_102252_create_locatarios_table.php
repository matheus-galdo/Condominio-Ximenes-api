<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocatariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locatarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf', 11);
            $table->timestamp('data_chegada')->nullable();
            $table->timestamp('data_saida')->nullable();
            $table->string('celular');
            $table->string('email');
            $table->text('observacoes')->nullable();
            $table->boolean('possui_veiculos');
            $table->boolean('possui_convidados');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            
        });

        Schema::create('locatario_veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('placa');
            $table->string('cor');
            $table->foreignId('locatario_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
        });


        Schema::create('locatario_convidados', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('celular');
            $table->string('email');
            $table->text('observacoes')->nullable();
            $table->foreignId('locatario_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locatario_convidados');
        Schema::dropIfExists('locatario_veiculos');
        Schema::dropIfExists('locatarios');
    }
}
