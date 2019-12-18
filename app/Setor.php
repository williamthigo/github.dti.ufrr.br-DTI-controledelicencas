<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends Model
{
    use SoftDeletes;
    protected $table = 'setores';
    protected $fillable = array('nome', 'sigla');
    protected $dates = ['deleted_at'];

    public function maquina(){
        return $this->hasMany(Maquina::class,'setores_id');
    }
}
