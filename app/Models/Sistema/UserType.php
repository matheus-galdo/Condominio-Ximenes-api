<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UserType extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'user_types';

    public $timestamps = false;
    public $fillable = ['nome', 'deleted_at', 'is_admin'];
    public $casts = ['is_admin' => 'boolean'];
    protected $dates = ['deleted_at'];



    public function permissoes()
    {
        return $this->hasMany(Permissoes::class);
    }

    public function permissoesWithModulo()
    {
        return $this->hasMany(Permissoes::class, 'user_type_id', 'id')->with(['modulo']);
    }
}
