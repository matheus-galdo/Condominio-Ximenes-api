<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartamentosProprietarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartamentos_proprietarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proprietario_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
            $table->foreignId('apartamento_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartamentos_proprietarios');
    }
}
