<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissoesSistema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos_sistema', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('label');
            $table->string('descricao');
            $table->boolean('interno');
        });

        Schema::create('permissoes', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('user_type_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('modulo_sistema_id')->constrained('modulos_sistema')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->boolean('acessar');
            $table->boolean('visualizar');
            $table->boolean('gerenciar');
            $table->boolean('criar');
            $table->boolean('editar');
            $table->boolean('excluir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos_sistema');
    }
}
