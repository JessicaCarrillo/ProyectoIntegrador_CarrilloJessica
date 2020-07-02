<?php

namespace App\gestionProyector;

use Illuminate\Database\Eloquent\Model;

class tbl_estados_devolucion extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_estados_devolucion';
    protected $primaryKey = 'id_estado';
    protected $fillable = ['descripcion', 'estado' ];
    public $timestamps=true;

    public function estado_devolucion(){
        return $this->hasMany('App\gestionProyector\tbl_ficha_proyector','id_estado_devolucion_fk','id_estado');
    }
    public  function estado_dev(){
        return $this->hasMany('App\gestionProyector\tbl_proyector','id_estado_devolucion','id_estado');
    }
}

