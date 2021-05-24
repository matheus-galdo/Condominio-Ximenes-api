<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatPortaria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_portaria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proprietario_id')->constrained('proprietarios')->onUpdate('cascade')->onDelete('cascade')->default(0);
        });

        Schema::create('chat_portaria_mensagens', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('autor_mensagem')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('chat_portaria_id')->constrained('chat_portaria')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->text('mensagem')->nullable();
            $table->boolean('mensagem_admin');
            $table->text('anexo')->nullable();
            $table->text('tipo_anexo')->nullable();
            $table->text('extensao')->nullable();
            $table->text('nome_original')->nullable();
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
        Schema::dropIfExists('chat_portaria');
        Schema::dropIfExists('chat_portaria_mensagens');
    }
}
