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
        Schema::create('evento_followup', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cor', 20);
        });

        Schema::create('ocorrencia_followup', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->default(0);
            $table->foreignId('ocorrencia_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('evento_followup_id')->constrained('evento_followup')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ocorrencia_anexos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_original');
            $table->string('extensao');
            $table->string('path')->unique();
            $table->foreignId('ocorrencia_followup_id')->constrained('ocorrencia_followup')->onUpdate('cascade')->onDelete('cascade')->default(0);
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
