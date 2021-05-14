<?php

namespace App\Models\Sistema;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UserType extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'user_types';

    public $timestamps = false;
    public $fillable = ['nome', 'deleted_at', 'is_admin', 'default_admin', 'default_user'];
    public $casts = ['is_admin' => 'boolean', 'default_admin' => 'boolean', 'default_user' => 'boolean'];
    protected $dates = ['deleted_at'];



    public function permissoes()
    {
        return $this->hasMany(Permissoes::class);
    }

    public function permissoesWithModulo()
    {
        return $this->hasMany(Permissoes::class, 'user_type_id', 'id')->with(['modulo']);
    }

    public function accessablePermissoesWithModulo()
    {
        return $this->hasMany(Permissoes::class, 'user_type_id', 'id')->with(['modulo'])->whereHas('modulo', function ($builder){
            $builder->where('interno', false);
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'type')->withTrashed();
    }

    public static function getAvailableTypes($isAdmin)
    {
        return self::where('is_admin', $isAdmin)->withTrashed()->get()->pluck('id')->toArray();            
    }
}
