<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOcorrenciaFollowup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ocorrencias', function(Blueprint $table){
            $table->boolean('concluida')->after('descricao')->default(false);
        });

        Schema::create('evento_followup', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });

        Schema::create('ocorrencia_followup', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->foreignId('ocorrencia_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('evento_followup_id')->constrained('evento_followup')->onUpdate('cascade')->onDelete('cascade')->default(0);
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
        Schema::dropIfExists('evento_followup');
        Schema::dropIfExists('ocorrencia_followup');
    }
}
