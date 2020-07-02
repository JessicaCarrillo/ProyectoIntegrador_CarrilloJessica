<?php

namespace App\Console\Commands;

use App\Mail\MensajeAsistencia;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use DB;
use App\gestionAsistencia\tbl_cronograma as cronograma;

class NotificacionSilaboCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'silabo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de mensajes no registro de silabo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $now = Carbon::now();
            $date_actual = $now->format('Y-m-d');
            $hora=$now->toTimeString();
            $estado_asistencia=DB::connection('SistemaEsfot')->select("SELECT tbl_cronograma.id_cronograma,email,fecha, hora_fin,tema from tbl_cronograma,`users`, tbl_periodo  WHERE users.id= tbl_cronograma.id_docente
         and tbl_periodo.id_periodo=tbl_cronograma.id_periodo and tbl_periodo.estado=1 and fecha='$date_actual' and mensaje_enviado=0  and tbl_cronograma.estado is null;");
            //dd($estado_asistencia);
            if(count($estado_asistencia)>0){
                foreach ($estado_asistencia as $estado){
                    $fecha_cronograma=$estado->fecha;
                    //dd($fecha_cronograma);
                    $fecha_plazo=date("Y-m-d",strtotime($fecha_cronograma."+ 2 days"));
                    $email=$estado->email;
                    $hora_fin=$estado->hora_fin;
                    $id=$estado->id_cronograma;

                    if($hora>$hora_fin){
                        $message=$estado->tema;
                        Mail::to($email)->queue(new MensajeAsistencia($message));
                        $cronograma=cronograma::find($id);
                        $cronograma->mensaje_enviado = 1;
                        $cronograma->save();
                    }
                    /*if( $date_actual > $fecha_cronograma ){
                        Mail::to($email)->queue(new MensajeAsistencia());
                        return "ok";

                    }else{
                        return "no";
                    }*/
                }

            }

        }catch
        (Exception $e) {
            Log::info($e->getMessage());
        }
    }

}
