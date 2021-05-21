<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_arquivos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('extensao');
            $table->string('path')->unique();
            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('grupo_contas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 5);
            $table->string('nome');
            $table->string('numero_cheque');
            $table->float('valor', 8, 2, true);
            $table->date('data');
            $table->foreignId('grupo_contas_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('conta_arquivo_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
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
        Schema::dropIfExists('contas');
    }
}
