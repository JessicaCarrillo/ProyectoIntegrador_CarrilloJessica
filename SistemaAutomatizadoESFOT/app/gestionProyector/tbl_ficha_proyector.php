<?php

namespace App\gestionProyector;

use Illuminate\Database\Eloquent\Model;

class tbl_ficha_proyector extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_ficha_proyector';
    protected $primaryKey = 'id_ficha_proyector';
    protected $fillable = ['fecha', 'hora_entrega', 'hora_retiro', 'id_estado_devolucion_fk', 'id_docente_fk', 'id_proyector_fk', 'estado' ];
    public $timestamps=true;

    public function reserva(){
        return $this->belongsTo('App\gestionProyector\tbl_proyector','id_proyector_fk','id_proyector');
    }
    public function registro(){
        return $this->belongsTo('App\User','id_docente_fk','id');
    }
    public function estado_devolucion(){
        return $this->belongsTo('App\gestionProyector\tbl_estados_devolucion','id_estado_devolucion_fk','id_estado');
    }



}
