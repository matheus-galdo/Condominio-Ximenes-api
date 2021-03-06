<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->text('descricao');
            $table->date('data_expiracao')->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
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
        Schema::dropIfExists('avisos');
    }
}
