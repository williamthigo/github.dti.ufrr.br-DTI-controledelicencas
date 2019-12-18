<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ativado extends Model
{
    use SoftDeletes;
    protected $table = 'ativados';
    protected $fillable = array('licencas_id', 'maquinas_id', 'users_id','ativados_id');
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }

    public function licenca(){
        return $this->belongsTo(Licenca::class,'licencas_id');
    }

    public function maquina(){
        return $this->belongsTo(Maquina::class,'maquinas_id');
    }

    public function ativado(){
        return $this->hasOne(Ativado::class,'ativados_id');
    }

    public function maquinaTrashed(){
        return $this->belongsTo(Maquina::class,'maquinas_id')->withTrashed();
    }


}
