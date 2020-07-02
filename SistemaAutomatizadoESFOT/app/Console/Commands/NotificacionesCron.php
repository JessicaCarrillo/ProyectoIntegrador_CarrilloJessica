<?php

namespace App\Console\Commands;

use App\gestionProyector\tbl_ficha_proyector as proyector;
use App\Mail\MessageReceived;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use DB;

class NotificacionesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de mensajes devolución proyector';

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
        try {
            $now = Carbon::now();
            $date_actual = $now->format('Y-m-d');
            $hora=$now->toTimeString();
            //$hora='22:10';
            $mensajes=DB::connection('SistemaEsfot')->select("SELECT id_ficha_proyector,fecha,hora_entrega,name,email FROM tbl_ficha_proyector, users WHERE id_docente_fk=users.id and 
            fecha='$date_actual' and tbl_ficha_proyector.estado=0;");
            if(count($mensajes)>0){
                foreach ($mensajes as $mensaje){
                    $id=$mensaje->id_ficha_proyector;
                    $hora_entrega=$mensaje->hora_entrega;
                    $email=$mensaje->email;
                    if ($hora > $hora_entrega) {
                        $proyectores=proyector::find($id);
                        $proyectores->atraso = "Atraso";
                        $proyectores->save();
                        Mail::to($email)->queue(new MessageReceived);

                        return "ok";

                    }else{
                        return "no";
                    }

                }


            }

        }catch
        (Exception $e) {
            Log::info($e->getMessage());
        }


        //
    }


}
