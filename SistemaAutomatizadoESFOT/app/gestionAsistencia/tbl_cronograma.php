<?php

namespace App\gestionAsistencia;

use Illuminate\Database\Eloquent\Model;

class tbl_cronograma extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_cronograma';
    protected $primaryKey = 'id_cronograma';
    protected $fillable = [
        'fecha', 'hora_inicio', 'hora_fin', 'capitulo','subcapitulo', 'tema', 'detalle', 'id_docente', 'id_periodo', 'id_materia','mensaje_enviado'
    ];
    public $timestamps=true;

    public function periodo(){
        return $this->belongsTo('App\gestionPeriodo\tbl_periodo','id_periodo','id_periodo');
    }

    public function cronograma(){
        return $this->belongsTo('App\User','id_docente','id');

    }

    public function asistencia(){
        return $this->hasMany('App\gestionAsistencia\tbl_ficha_asistencia','id_cronograma','id_cronograma');

    }

    public function materias_cro(){
        return $this->belongsTo('App\gestionAsistencia\tbl_materia','id_materia','id_materia');

    }
}
