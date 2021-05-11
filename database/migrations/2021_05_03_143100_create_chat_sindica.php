<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatSindica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_sindica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proprietario_id');
            $table->foreign('proprietario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->unsignedBigInteger('sindica_id');
            $table->foreign('sindica_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade')->default(0);
        });

        Schema::create('chat_sindica_mensagens', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('autor_mensagem')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('destinatario_mensagem')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('chat_sindica_id')->constrained('chat_sindica')->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->text('mensagem');
            $table->text('anexo')->nullable();
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
        Schema::dropIfExists('chat_sindica');
        Schema::dropIfExists('chat_sindica_mensagens');
    }
}
