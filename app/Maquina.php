<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maquina extends Model
{
    use SoftDeletes;
    protected $table = 'maquinas';
    protected $fillable = array('tombo', 'setores_id');
    protected $dates = ['deleted_at'];

    public function ativado(){
        return $this->hasMany(Ativado::class,'maquinas_id');
    }

    public function setor(){
        return $this->belongsTo(Setor::class,'setores_id');
    }
}
