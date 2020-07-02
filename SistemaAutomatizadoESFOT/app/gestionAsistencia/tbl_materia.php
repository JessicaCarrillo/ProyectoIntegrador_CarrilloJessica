<?php

namespace App\gestionAsistencia;

use Illuminate\Database\Eloquent\Model;

class tbl_materia extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_materia';
    protected $primaryKey = 'id_materia';
    protected $fillable = ['materia', 'id_carrera_fk', 'estado' ];
    public $timestamps=true;

    public function materias(){
        return $this->belongsTo('App\gestionAsistencia\tbl_carrera','id_carrera_fk','id_carrera');

    }

    public function materias_cro(){
        return $this->hasMany('App\gestionAsistencia\tbl_cronograma','id_materia','id_materia');

    }


}
