<?php

namespace App\Http\Controllers;

use App\Models\DiarioTurnoRotativo;
use App\Models\DiarioTurnoFijo;

class DiariosController extends Controller
{
    public function updateDiarioTurnoRotativo($id)
    {
        $diario = DiarioTurnoRotativo::findOrFail($id);

        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'fecha' => 'required',
            'turno_rotativo_id' => 'required',
            'hora_entrada_uno' => 'required',
            'hora_salida_uno' => 'required',
            'img_uno' => '',
            'img_dos' => '',
        ]);
 
        $diario->update($atributos);

        return response()->json(['message' => 'Diario actualizado correctamente']);
    }


    public function updateDiarioTurnoFijo($id)
    {
        $diario = DiarioTurnoFijo::findOrFail($id);

        $atributos = request()->validate([
            'funcionario_id' => 'required',
            'fecha' => 'required',
            'turno_fijo_id' => 'required',
            'hora_entrada_uno' => 'required',
            'hora_salida_uno' => 'required',
            'hora_entrada_dos' => 'required',
            'hora_salida_dos' => 'required',
            'img_uno' => '',
            'img_dos' => '',
        ]);

        $diario->update($atributos);

        return response()->json(['message' => 'Diario Fijo actualizado correctamente']);
    }

    public static function guardarDiarioTurnoFijo($datos)
    {
        DiarioTurnoFijo::create($datos);
        return true;
    }    
    public static function actualizaDiarioTurnoFijo($datos,$id)
    {
        $diario = DiarioTurnoFijo::findOrFail($id);
        $diario->update($datos);
    }
    public static function guardarDiarioTurnorotativo($datos)
    {
        DiarioTurnoRotativo::create($datos);
        return true;
    } 
    public static function actualizaDiarioTurnoRotativo($datos,$id)
    {
        $diario = DiarioTurnoRotativo::findOrFail($id);
        $diario->update($datos);
    }
}
