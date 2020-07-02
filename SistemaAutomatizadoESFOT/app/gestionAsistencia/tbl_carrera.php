<?php

namespace App\gestionAsistencia;

use Illuminate\Database\Eloquent\Model;

class tbl_carrera extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_carrera';
    protected $primaryKey = 'id_carrera';
    protected $fillable = ['carrera', 'estado' ];
    public $timestamps=true;

    public function materias(){
        return $this->hasMany('App\gestionAsistencia\tbl_materia','id_carrera_fk','id_carrera');

    }
}
