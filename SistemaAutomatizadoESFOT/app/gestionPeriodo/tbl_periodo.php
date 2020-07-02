<?php

namespace App\gestionPeriodo;

use Illuminate\Database\Eloquent\Model;

class tbl_periodo extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_periodo';
    protected $primaryKey = 'id_periodo';
    protected $fillable = ['periodo', 'fecha_inicio', 'fecha_fin', 'estado' ];
    public $timestamps=true;

    public function periodo(){
        return $this->hasMany('App\gestionAsistencia\tbl_cronograma','id_periodo','id_periodo');
    }
}
