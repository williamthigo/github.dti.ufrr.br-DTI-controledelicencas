<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licenca extends Model
{
    use SoftDeletes;
    protected $table = 'licencas';
    protected $fillable = array('serial', 'arquivo','tipos_id','disponivel','utilizada');
    protected $dates = ['deleted_at'];

    public function ativado(){
        return $this->hasMany(Ativado::class,'licencas_id');
    }

    public function tipo(){
        return $this->belongsTo(Tipo::class,'tipos_id');
    }

}
