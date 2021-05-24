<?php

namespace App\Models\PrestacaoContas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    public $fillable = [
        'codigo',
        'nome',
        'grupo_contas_id',
        'numero_cheque',
        'valor',
        'data',
    ];

    public function grupoContas()
    {
        return $this->belongsTo(GrupoConta::class);
    }
}

// Schema::create('conta_arquivos', function (Blueprint $table) {
//     $table->id();
//     $table->string('nome');
//     $table->string('extensao');
//     $table->string('path')->unique();
//     $table->softDeletes();
//     $table->timestamps();
// });


// Schema::create('grupo_contas', function (Blueprint $table) {
//     $table->id();
//     $table->string('nome');
//     $table->foreignId('conta_arquivo_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
//     $table->timestamps();
// });

// Schema::create('contas', function (Blueprint $table) {
//     $table->id();
//     $table->string('codigo', 5);
//     $table->string('nome');
//     $table->string('numero_cheque');
//     $table->float('valor', 8, 2, true);
//     $table->date('data');
//     $table->foreignId('grupo_contas_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->default(0);
//     $table->timestamps();
// });