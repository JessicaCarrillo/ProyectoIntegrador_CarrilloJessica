<?php

namespace App\Console\Commands;

use App\gestionPeriodo\tbl_periodo as periodo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PeriodoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'periodo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activar o desactivar periodo';

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
            $estado_periodo=periodo::where('estado',1)->get();

            function check_in_range($fecha_inicio, $fecha_fin, $fecha){
                $fecha_inicio = strtotime($fecha_inicio);
                $fecha_fin = strtotime($fecha_fin);
                $fecha = strtotime($fecha);
                if(($fecha >= $fecha_inicio) && ($fecha <= $fecha_fin))
                    return true;
                else
                    return false;
            }
            if(count($estado_periodo)>0){
                foreach ($estado_periodo as $estado){
                    $id=$estado->id_periodo;
                    $fecha_inicio=$estado->fecha_inicio;
                    $fecha_fin=$estado->fecha_fin;
                    if(!check_in_range($fecha_inicio,$fecha_fin,$date_actual)){
                        $periodo = periodo::find($id);
                        $periodo->estado = 0;
                        $periodo->save();

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
