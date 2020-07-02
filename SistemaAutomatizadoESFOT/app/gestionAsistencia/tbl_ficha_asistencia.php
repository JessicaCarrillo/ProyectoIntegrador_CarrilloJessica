<?php

namespace App\gestionAsistencia;

use Illuminate\Database\Eloquent\Model;

class tbl_ficha_asistencia extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_ficha_asistencia';
    protected $primaryKey = 'id_asistencia';
    protected $fillable = ['id_cronograma', 'observacion', 'hora_registro', 'fecha_registro' ];
    public $timestamps=true;


    public function asistencia(){
        return $this->belongsTo('App\gestionAsistencia\tbl_cronograma','id_cronograma','id_cronograma');

    }
}
