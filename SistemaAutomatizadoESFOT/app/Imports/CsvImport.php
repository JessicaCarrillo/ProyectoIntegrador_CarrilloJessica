<?php

namespace App\Imports;

use App\gestionAsistencia\tbl_cronograma;
use App\gestionAsistencia\tbl_cronograma as cronograma;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Date;
use League\Flysystem\Exception;
class CsvImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (Exception $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }

    public function model(array $row)
    {
      //  dd(  $row['hora_inicio'].':00');

       // $date = Carbon::now();

        $cronogramas = $_POST["id_docente"];
        $periodos=$_POST["id_periodo"];
        $materias=$_POST["id_materia"];
        $hora_inicio1=$row['hora_inicio'].':00';
        $hora_inicio=strtotime($hora_inicio1);
        $hora_fin1=$row['hora_fin'].':00';
        $hora_fin=strtotime($hora_fin1);
        $mensaje=$_POST["estado_mensaje"];
        //dd($cronogramas);
        return new tbl_cronograma([
            'fecha' =>  $this->transformDate($row['fecha']),
            'hora_inicio' => date('H:i:s', $hora_inicio),
            'hora_fin' =>  date('H:i:s', $hora_fin),
            'capitulo' =>  $row['capitulo'],
            'tema' =>  $row['tema'],
            'detalle' =>  $row['detalle'],
            'id_docente' =>  $cronogramas,
            'id_periodo' => $periodos,
            'id_materia' => $materias,
            'mensaje_enviado'=>$mensaje,
        //
        ]);
    }
}
