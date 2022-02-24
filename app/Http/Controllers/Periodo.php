<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Models\Periodo as ModelsPeriodo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class Periodo extends Controller
{
    public function create(Request $request)
    {
        $gestion = Gestion::find($request->id_gestion);
        $request->validate([
            'id_gestion' => 'required|exists:gestion,id_gestion',
            'nombre' => 'required|string|max:20|min:3',
            'fecha_inicio' => 'required|date|after_or_equal:' . $gestion->fecha_inicio . '|before_or_equal:' . $gestion->fecha_fin,
            'fecha_fin' => 'required|date|after:fecha_inicio|before_or_equal:' . $gestion->fecha_fin,
        ]);
        /*
            Validar que el usuario sea el que está creando el periodo. 👇
        */
        if (ModelsPeriodo::where('id_usuario', Auth::user()->id_usuario)->get()->count() == 0) {
            return response()->json(['success' => false], 400);
        }
        //  ============================================= 👆
        /*
            Validar que el  nombre no sea repetido para el periodo en la gestión 👇
            =============================================
        */
        if (ModelsPeriodo::where('nombre', $request->nombre)->where('id_gestion', $request->id_gestion)->get()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Ese nombre ya existe.'], 400);
        }
        //  =============================================👆
        /*
            Crear el periodo 👇
        */
        /* Hay que validar si se solapan? */
        ModelsPeriodo::create([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'id_usuario' => Auth::user()->id_usuario,
            'id_gestion' => $request->id_gestion,
            'estado' => 1
        ]);
        return response()->json(['success' => true]);
    }
    public function getPeriodoDeGestion(Request $request)
    {
        $request->validate([
            'id_gestion' => 'required|integer'
        ]);
        //Validar usuario
        $gestion = ModelsPeriodo::where('id_gestion', $request->id_gestion)->where('id_usuario', Auth::user()->id_usuario)->get();
        return DataTables::of($gestion)->make(true);
    }
    public function cambiarEstadoPeriodo(Request $request)
    {
        $request->validate([
            'id_periodo' => 'required|integer',
        ]);
        if (ModelsPeriodo::where('id_usuario', Auth::user()->id_usuario)->where('id_periodo', $request->id_periodo)->get()->count() == 0) {
            return response()->json(['success' => false], 400);
        }
        /*
            No sé si hay limite de periodos abiertos así como gestiones (Máximo 2) así que si se aplica, lo dejo comentado 👇
            =============================================
        if (ModelsPeriodo::where('estado', 1)->where('id_gestion', $request->id_gestion)->get()->count() >= 2) {
            return response()->json(['success' => false, 'message' => 'Solo puedes tener 2 periodos abiertos.'], 400);
        }
            Borrar esta caca si aplica.
        */
        $periodo = ModelsPeriodo::find($request->id_periodo);
        $periodo->estado = $periodo->estado == 1 ? 0 : 1;
        $periodo->save();
        return response()->json(['success' => true]);
    }
    public function actualizarPeriodo(Request $request)
    {
        $gestion = Gestion::find($request->id_gestion);
        $request->validate([
            'id_periodo' => 'required|integer|exists:periodo,id_periodo',
            'nombre' => 'required|string|max:20|min:3',
            'fecha_inicio' => 'required|date|after_or_equal:' . $gestion->fecha_inicio . '|before_or_equal:' . $gestion->fecha_fin,
            'fecha_fin' => 'required|date|after:fecha_inicio|before_or_equal:' . $gestion->fecha_fin,
        ]);
        /*
            Validar que el usuario sea el que está creando el periodo. 👇
        */
        if (ModelsPeriodo::where('id_usuario', Auth::user()->id_usuario)->get()->count() == 0) {
            return response()->json(['success' => false], 400);
        }
        //  ============================================= 👆
        /*
            Validar que el  nombre no sea repetido para el periodo 👇
            =============================================
        */
        $periodo = ModelsPeriodo::where('nombre', $request->nombre)->where('id_gestion', $request->id_gestion);
        if ($periodo->get()->count() > 0 && $periodo->first()->id_periodo != $request->id_periodo) {
            return response()->json(['success' => false, 'message' => 'Ese nombre ya existe.'], 400);
        }
        //  =============================================👆
        ModelsPeriodo::find($request->id_periodo)->update([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
        return response()->json(['success' => true]);
    }
}