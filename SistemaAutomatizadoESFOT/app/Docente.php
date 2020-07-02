<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Docente extends Authenticatable
{
    use Notifiable;

    protected $guarded = 'docente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'SistemaEsfot';
    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cronograma(){
        return $this->hasMany('App\gestionAsistencia\tbl_cronograma','id_docente','id_docente');

    }

    public function rol(){
        return $this->belongsTo('App\gestionAsistencia\tbl_roles','tipo_rol','id_rol');

    }



}
