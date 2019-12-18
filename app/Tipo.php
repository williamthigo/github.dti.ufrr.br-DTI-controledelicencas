<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use SoftDeletes;
    protected $table = 'tipos';
    protected $fillable = array('nome');
    protected $dates = ['deleted_at'];

    public function licenca(){
        return $this->hasMany(Licenca::class);
    }
}
