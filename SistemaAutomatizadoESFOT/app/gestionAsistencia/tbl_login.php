<?php

namespace App\gestionAsistencia;

use Illuminate\Database\Eloquent\Model;

class tbl_login extends Model
{
    protected $connection = 'SistemaEsfot';
    protected $table = 'tbl_login';
    protected $primaryKey = 'id_login';
    protected $fillable = [
        'iud', 'id_biometrico', 'checktime', 'status', 'checktype', 'sensorid',
    ];
    public $timestamps=true;
}
