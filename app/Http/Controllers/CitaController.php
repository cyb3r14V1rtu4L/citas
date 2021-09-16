<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Sede;
use App\Models\Entrevistador;
use App\Models\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    public function createHorarios() {

        $Institucions = Institucion::get();
        $Institucions = $Institucions->toArray();

        $Sedes = Sede::get();
        $Sedes = $Sedes->toArray();

        $Entrevistadors = Entrevistador::get();
        $Entrevistadors = $Entrevistadors->toArray();


        $startTime = strtotime( '2021-03-01 09:00');
        $endTime = strtotime( '2021-03-14 17:00');

        $horarios = array();
        $n=0;
        $x=0;
        for ($i = $startTime; $i <= $endTime; $i = $i + 1200) {
            $NuevaFecha = strtotime('+00 minute', $i);
            $thisDate = date('Y-m-d H:i:s', $NuevaFecha);
            $thisTime = date('H:i:s', strtotime($thisDate));
            if ($thisTime < date('17:00:00') && $thisTime >= date('09:00:00')) {
                //array_push($horarios, $thisDate);
                $horarios[$x][$n] = $thisDate;
                $n++;
                if($n==24) {
                    $x++;
                    $n=0;
                }
            }
        }

        $Cita = array();

        #15e x 24h x 3s = 1080
        foreach ($Sedes as $s=>$sede) {
            foreach ($Entrevistadors as $e=>$entrevistador) {
                $entrevistador['sede_id'] = $sede['id'];
                $Cita[$s][$e] = $entrevistador;
                $Cita[$s][$e]['horario'] = $horarios;
            }
        }

        $Horario = array();
        $Horarios = array();

        foreach ($Cita as $s=>$Sede) {
            foreach ($Sede as $Horariox) {
                $Horario['entrevistador_id'] = $Horariox['id'];
                foreach ($Horariox['horario'] as $horario) {
                    foreach ($horario as $hora) {
                        $Horario['sede_id'] = $Sede[$s]['sede_id'];
                        $hora_inicio= date('H:i:s', strtotime ($hora));
                        $hora_inicio = strtotime ( '00 minute' , strtotime ($hora_inicio) ) ;
                        $hora_inicio = date('H:i:s', $hora_inicio);
                        $Horario['hora_inicio'] = $hora_inicio;

                        $hora_fin= date('H:i:s', strtotime ($hora));
                        $hora_fin = strtotime ( '20 minute' , strtotime ($hora_fin) ) ;
                        $hora_fin = date('H:i:s', $hora_fin);
                        $Horario['hora_fin'] = $hora_fin;

                        $fecha = date('Y-m-d', strtotime ($hora));
                        $fecha = strtotime ( '00 minute' , strtotime ($fecha) ) ;
                        $fecha = date('Y-m-d', $fecha);
                        $Horario['fecha'] = $fecha;
                        $Horario['estatus'] = 0;
                        Cita::insert($Horario);
                    }
                }
            }
        }
    }


    public function getCitasDiponibles() {

        try {
            $Citas = Cita::where('estatus', 0)
                ->orderBy('sede_id', 'ASC')
                ->orderBy('fecha', 'ASC')
                ->orderBy('hora_inicio', 'ASC')
                ->get()->toArray();

            $Citas[0]['estatus'] = 1;

            $Cita = Cita::findOrFail($Citas[0]['id']);
            $Cita->estatus = 1;
            $Cita->user_id =  random_int(1,999);
            $Cita->save();

            return response()->json([
                "response" => "success",
                "message" => "Lista recuperada satisfactoriamente.",
                "data" => $Cita
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "response" => "error",
                    "message" => $e->getMessage()
                ]
            );
        }
    }

    public function getCitasDisponiblesByFecha(Request $request) {
        $input = $request->all();

        try {
            $Citas = Cita::where('estatus', 0)
                ->where('fecha',$input['fecha'])
                ->orderBy('fecha', 'ASC')
                ->orderBy('hora_inicio', 'ASC')
                ->get()->toArray();

            return response()->json([
                "response" => "success",
                "message" => "Lista recuperada satisfactoriamente.",
                "data" => $Citas
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "response" => "error",
                    "message" => $e->getMessage()
                ]
            );
        }
    }


    public function getCitasDisponiblesByFechaEstatus(Request $request) {
        $input = $request->all();

        try {
            $Citas = Cita::where('fecha',$input['fecha'])
                ->where('estatus',$input['estatus'])
                ->orderBy('fecha', 'ASC')
                ->orderBy('hora_inicio', 'ASC')
                ->get()->toArray();

            return response()->json([
                "response" => "success",
                "message" => "Lista recuperada satisfactoriamente.",
                "data" => $Citas
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "response" => "error",
                    "message" => $e->getMessage()
                ]
            );
        }
    }

}

